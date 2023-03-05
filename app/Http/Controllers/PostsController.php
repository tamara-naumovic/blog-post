<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //get ruta - jer prihvatamo podatke iz baze
    {
        // vraca sve postove iz baze
        $posts = Post::all();
        // return response()->json($posts);
        return view('blog.index',[
            'posts'=>$posts
        ]);

        //izmena ako vraca samo postove korisnika koji ih je postavio
        // $user = Auth::user();
        // $user_posts = $user->posts;
        // return view('blog.index',[
        //     'posts'=>$user_posts
        // ]);
        //ili ako hocemo da prikazujemo sve na home a preko /my samo za ulogovanog
        // mozemo da izmenimo show 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() //get ruta - jer zelimo da prikazemo create form view
    {
        $categories = Category::all();
        $users = User::all();
        return view('blog.create',[
            'categories'=>$categories,
            'users'=>$users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //post ruta - jer saljemo post zahtev i create u bazu
    {
        $newPost = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'excerpt' => $request->excerpt,
            'slug' => $request->slug,
            'user_id' => Auth::id(), //izmena za autentifikovanogg usera
            'category_id' => $request->category,
        ]);

        return redirect('blog/' . $newPost->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($postid) //get ruta - jer prihvatamo podatke iz baze
    {
        // $post = Post::find($postid);

        // return view('blog.show', [
        //     'post' => $post,
        // ]); 
        if($postid=='my'){
            //izmena ako vraca samo postove korisnika koji ih je postavio
            $user = Auth::user();
            $user_posts = $user->posts;
            return view('blog.index',[
                'posts'=>$user_posts
            ]);
        }else{

            //izmena ako za autentifikaciju
            $post = Post::find($postid);
            $user = Auth::id();
            return view('blog.show', [
                'post' => $post,
                'auth_user'=>$user
            ]); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($postid) //get ruta - jer zelimo da prikazemo edit form view
    {
        // $post = Post::find($postid);
        // $categories = Category::all();

        // return view('blog.edit', [
        //     'post' => $post,
        //     'categories'=>$categories,
        //     ]);
        
        //izmena sa autentifikacijom
        $user = Auth::user();
        $post = Post::find($postid);
        if($user->id == $post->user->id){
            $categories = Category::all();

        return view('blog.edit', [
            'post' => $post,
            'categories'=>$categories,

        ]);
        }else{
            return redirect('blog/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $postid) //put ruta - jer saljemo put zahtev i update u bazu
    {
        $post = Post::find($postid);
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'excerpt' => $request->excerpt,
            'category_id' => $request->category,
        ]);
        return redirect('blog/' . $post->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($postid) //delete ruta - jer zelimo da obrisemo iz baze jedan red
    {
        // $post = Post::find($postid);
        // $post->delete();
        // return redirect('/blog');

        //izmena za autentifikaciju
        $post = Post::find($postid);
        if($post->user->id == Auth::id()){
            $post->delete();
        }
        return redirect('/blog');
        
        

    }
}
