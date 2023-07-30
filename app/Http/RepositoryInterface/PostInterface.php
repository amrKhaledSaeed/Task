<?php
namespace App\Http\RepositoryInterface;

interface PostInterface{
public function index();
public function store($request);
public function show($id);
public function update($request,$id);
public function destroy($id);
public function viewDeletedPosts();
public function restoreDeletedPosts($id);
public function forceDelete();


}
