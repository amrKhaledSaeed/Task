<?php
namespace App\Http\RepositoryInterface;

interface TagsInterface{
public function index();
public function store($request);
public function show($id);
public function update($request,$id);
public function destroy($id);

}
