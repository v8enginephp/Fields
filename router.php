<?php

use Core\App;
use Module\Fields\Controller\FieldsController;
use Module\Fields\Middleware\FieldsMiddleware;

\Illuminate\Support\Facades\Route::get("field", function () {
    $a = (new \Module\Fields\Input("text", ["text" => "ali", "class" => "form-control border border-danger"]))->setValue("salam ali 😄")->setLabel("Wtf");
    $a .= (new \Module\Fields\Input("checkbox", ["text" => "ali", "class" => "form-control border border-danger"]))->setValue("salam ali 😄")->setLabel("Wtf");

    $a .= (new \Module\Fields\Select([
        (new \Module\Fields\Option("ali", "علی")),
        (new \Module\Fields\Option("reza", "رضا")),
        (new \Module\Fields\Option("negin", "نگین"))
    ], ["class" => "form-control"]))->setLabel('کاربران سایت')->setValue('negin');


    $a .= (new \Module\Fields\Select(function () {
        $posts = \Module\CMS\Model\Post::all();
        $output = [];
        foreach ($posts as $post) {
            $output[] = (new \Module\Fields\Option($post->id, $post->title));
        }
        return $output;
    }, ["class" => "form-control"]))->setLabel('پست های سایت');

    $a .= (new \Module\Fields\Textarea(['class' => "form-control border border-success"]))->setValue('Lol')->setLabel('Lol :');
    $a.="<hr>";
    $a.=comment_form(1);
    return template('dashboard')->blank($a);
});