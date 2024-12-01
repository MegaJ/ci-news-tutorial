<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);
        $data = [
            'news_list' => $model->getNews(),
            'title' => 'News archive',
        ];

        return view('templates/header', $data)
            . view('news/index')
            . view('templates/footer');
    }

    public function show(?string $slug = null)
    {
        $model = model(NewsModel::class);
        $data['news'] = $model->getNews($slug);

        if ($data['news'] === null) {
            throw new PageNotFoundException('Cannot find the news item: ' . $slug);
        }
        $data['title'] = $data['news']['title'];

        return view('templates/header', $data)
            . view('news/view')
            . view('templates/footer');
    }

    public function new()
    {
        // https://codeigniter.com/user_guide/general/helpers.html
        // allows us to use form helpers in the template
        helper('form');

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/create')
            . view('templates/footer');
    }

    public function create()
    {
        helper('form');
        // title and body are fields in the form
        // how would I print out everything in the request object?
        // var_dump($this->request);
        $data = $this->request->getPost(['title', 'body']);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData(
            $data, [
            // Why is this happening at the controller level?
            // Rails would put this on the model level,
            // and when we display errors, we get the errors from the model
            'title' => 'required|max_length[255]|min_length[3]',
            'body' => 'required|max_length[5000]|min_length[10]',
            ]
        )
        ) {
            // validation fails, return to the form
            return $this->new();
        }
        // Where does this validator property come from?
        // https://codeigniter.com/user_guide/libraries/validation.html#validation-getting-validated-data
        $post = $this->validator->getValidated();
        $model = model(NewsModel::class);
        $model->save(
            [
            'title' => $post['title'],
            'slug' => url_title($post['title'], '-', true),
            'body' => $post['body'],
            ]
        );

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/success')
            . view('templates/footer');
    }
}
