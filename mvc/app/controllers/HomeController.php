<?php
namespace App\Controllers;

use App\Models\Category;

class HomeController extends BaseController{
    public function index(){
        // hiển thị danh sách danh mục
        // 1. lấy dữ liệu danh mục bằng model
        $cates = Category::all();
        $cates->load([
            'products'
        ]);
        // echo "<pre>";
        // var_dump($cates);die;
        // 2. render ra view kèm dữ liệu
        // categories/index.blade.php
        $this->render('categories.index', [
            'cates' => $cates
        ]);
    }

    public function remove(){
        $id = isset($_GET['id']) ? $_GET['id'] : -1;
        $model = Category::find($id);
        if($model){
            $model->delete();
        }
        header('location: ' . BASE_URL);
    }

    public function addForm()
    {
        $this->render('categories.add-form');
    }
    public function editForm()
    {
        $cateid = isset($_GET['id']) ? $_GET['id']  : -1;
        $model = Category::find($cateid);
        if(!$model){
            header('location: ' . BASE_URL);
        }
        $this->render('categories.edit-form', compact('model'));

    }

    public function saveAddCate(){
        $data = $_POST;
        $cate = new Category();
        $cate->fill($data);
        
        $cate->save();
        header('location: ' . BASE_URL);
        die;
    }
    public function saveEditCate(){
        $id = $_POST['id'];
        $cate = Category::find($id);
        if($cate) {
            $data = $_POST;
            $data['show_menu'] = isset($data['show_menu']) ? $data['show_menu'] : 0;
            $cate->fill($data);
            $cate->save();
        }
        header('location: ' . BASE_URL); die;
    }
}

?>