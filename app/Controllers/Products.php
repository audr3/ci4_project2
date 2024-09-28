<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->findAll();
        return view('products/index', $data);
    }

    public function create()
    {
        return view('products/create');
    }

    public function store()
    {
        $productModel = new ProductModel();
        $data = [
            'name'          => $this->request->getPost('name'),
            'price'         => $this->request->getPost('price'),
            'description'   => $this->request->getPost('description'),
            'category'      => $this->request->getPost('category'),
        ];

        $productModel->insert($data);
        return redirect()->to(base_url('/products'));
    }

    public function edit($id)
    {
        $productModel = new ProductModel();
        $data['product'] = $productModel->find($id);
        return view('products/edit', $data);
    }

    public function update($id)
    {
        $productModel = new ProductModel();
        $data = [
            'name'          => $this->request->getPost('name'),
            'price'         => $this->request->getPost('price'),
            'description'   => $this->request->getPost('description'),
            'category'      => $this->request->getPost('category'),
        ];

        $productModel->update($id, $data);
        echo $data;
        // return redirect()->to(base_url('/products'));
    }

    public function delete($id) 
    {
        $productModel = new ProductModel();
        $productModel->delete($id);
        return redirect()->to(base_url('/products'));
    }
}
