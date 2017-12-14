<?php
namespace App;

use App\Providers\AppServiceProvider;
use App\Interfaces\CodeInterface;

class Github implements CodeInterface
{

    public $end_point = "https://api.github.com/";
    public $username;
    public $password;

    public function search($request)
    {

        $this->username = $request->getUser();
        $this->password = $request->getPassword();

        $q = $request->input('q');
        $page = $request->input('page');
        $per_page = (int)$request->input('per_page');
        $order = $request->input('order');
        $sort = $request->input('sort');

        if (!isset($page))
            $page = 1;
        if (!isset($per_page))
            $per_page = 25;

        $params = [
            'q' => $q,
            'page' => $page,
            'per_page' => $per_page,
            'order' => $order,
            'sort' => $sort
        ];
        $headers = [
            'User-Agent:' . $this->username
        ];
        $result = AppServiceProvider::sendHttpRequest($this->end_point . "search/code", $type = "GET", $params, $headers, $data_type = "array", $this->username, $this->password);

        return $this->prepareResponse($result, $page, $per_page);
    }

    private function prepareResponse($result, $page, $per_page)
    {
        $message = $result;
        $result = json_decode($result);

        if (json_last_error() != JSON_ERROR_NONE) {
            $response = [
                'status' => 0,
                'error' => $message
            ];
            return $response;
        }
        if(!empty($result->errors)){
            return $result;
        }

        $response = [];
        $response['status'] = 1;
        $response['total_count'] = $result->total_count;
        $response['page'] = $page;
        $response['per_page'] = $per_page;

        foreach ($result->items as $r) {
            $response['result'][] = [
                'filename' => $r->name,
                'url' => $r->html_url,
                'repository' => $r->repository->name,
                'repository_url' => $r->repository->html_url,
                'owner_handle' => $r->repository->owner->login,
                'owner_url' => $r->repository->owner->html_url,
                'owner_avatar' => $r->repository->owner->avatar_url
            ];
        }
        return $response;
    }

}