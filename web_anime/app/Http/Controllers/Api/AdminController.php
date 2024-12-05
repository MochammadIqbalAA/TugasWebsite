<?php

namespace App\Http\Controllers\Api;

//import model Post
use App\Models\Admin;

use Illuminate\Http\Request;

//import resource PostResource
use App\Http\Controllers\Controller;

//import Http request
use App\Http\Resources\AdminResource;

//import facade Validator
use Illuminate\Support\Facades\Validator;

//import facade Storage
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $posts = Admin::latest()->paginate(5);
        //return collection of posts as a resource
        return new AdminResource(true, 'List Data Posts', $posts);
    }


     /**
     * store
     *
     * @param mixed $request
     * @return void
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);
        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Admin::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password
        ]);
        //return response
        return new AdminResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }

    /**
     * show
     *
     * @param mixed $id
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $post = Admin::find($id);
        //return single post as a resource
        return new AdminResource(true, 'Detail Data Post!', $post);
    }


    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'     => 'required',
            'username'   => 'required',
            'password'   => 'required',

        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $post = Admin::find($id);

            //update post without image
            $post->update([
                'nama'     => $request->nama,
                'username'   => $request->username,
                'password'   => $request->password,
            ]);
        

        //return response
        return new AdminResource(true, 'Data Post Berhasil Diubah!', $post);
    }


/**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {

        //find post by ID
        $post = Admin::find($id);

        //delete image
        Storage::delete('public/posts/'.basename($post->image));

        //delete post
        $post->delete();

        //return response
        return new AdminResource(true, 'Data Post Berhasil Dihapus!', null);
    }

}
