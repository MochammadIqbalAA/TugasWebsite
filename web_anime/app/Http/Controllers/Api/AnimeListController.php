<?php
namespace App\Http\Controllers\Api;
//import model Post
use App\Models\anime_list;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnimeListResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AnimeListController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $posts = anime_list::latest()->paginate(5);
        //return collection of posts as a resource
        return new AnimeListResource(true, 'List Data Posts', $posts);
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'year' => 'required',
            'description' => 'required'
        ]);
        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());
        //create post
        $post = anime_list::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'year' => $request->year,
            'description' => $request->description,
        ]);
        //return response
        return new AnimeListResource(true, 'Data Post Berhasil Ditambahkan!', $post);
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
        $post = anime_list::find($id);
        //return single post as a resource
        return new AnimeListResource(true, 'Detail Data Post!', $post);
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
            'title'     => 'required',
            'year'   => 'required',
            'description'   => 'required',

        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $post = anime_list::find($id);

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old image
            Storage::delete('public/posts/' . basename($post->image));

            //update post with new image
            $post->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'year'   => $request->year,
                'description'   => $request->description,

            ]);
        } else {

            //update post without image
            $post->update([
                'title'     => $request->title,
                'year'   => $request->year,
                'description'   => $request->description,
            ]);
        }

        //return response
        return new AnimeListResource(true, 'Data Post Berhasil Diubah!', $post);
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
        $post = anime_list::find($id);

        //delete image
        Storage::delete('public/posts/'.basename($post->image));

        //delete post
        $post->delete();

        //return response
        return new AnimeListResource(true, 'Data Post Berhasil Dihapus!', null);
    }

}