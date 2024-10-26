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

        if($imageFile = $this->request->getFile('product_image')) {
            if($imageFile->isValid() && !$imageFile->hasMoved()) {
                $newName = $imageFile->getRandomName();
                $imageFile->move(WRITEPATH . '../public/uploads', $newName);

                $data = [
                    'name'          => $this->request->getPost('name'),
                    'price'         => $this->request->getPost('price'),
                    'description'   => $this->request->getPost('description'),
                    'category'      => $this->request->getPost('category'),
                    'image'         => $newName,
                ];

                $productModel->insert($data);
                return redirect()->to(base_url('/products'))->with('message', 'File berhasil diupload');
                {
                    return redirect()->back()->withInput()->with('error', 'File tidak valid');
                }
            }
        }
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
        $product = $productModel->find($id);

        $imageFile = $this->request->getFile('product_image');
        if($imageFile->isValid() && !$imageFile->hasMoved()) {
            $newName = $imageFile->getRandomName();
            $imageFile->move(WRITEPATH . '../public/uploads', $newName);

            // Delete old images
            if($product['image'] && file_exists(WRITEPATH . '../public/uploads/' . $product['image'])) {
                unlink(WRITEPATH . '../public/uploads/' . $product['image']);
            }
        } else {
            $newName = $product['image']; // Keep old image if no new image uploaded
        }

        $data = [
            'name'          => $this->request->getPost('name'),
            'price'         => $this->request->getPost('price'),
            'description'   => $this->request->getPost('description'),
            'category'      => $this->request->getPost('category'),
            'image'         => $newName,
        ];

        $productModel->update($id, $data);
        // echo($data);
        return redirect()->to(base_url('/products'));
    }

    public function delete($id) 
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        // Delete image
        if($product['image'] && file_exists(WRITEPATH . '../public/uploads/' . $product['image'])) {
            unlink(WRITEPATH . '../public/uploads/' . $product['image']);
        }

        $productModel->delete($id);
        return redirect()->to(base_url('/products'))->with('message', 'Product deleted successfully');
    }
}
