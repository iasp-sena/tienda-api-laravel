<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Product;
use App\Validators\ProductValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends ApiController
{

    private const PARAM_ID = "id";
    private const PARAM_PAGE = "page";

    public function getProducts(Request $request) {
        DB::enableQueryLog();
        $this->setParamRouterToRequest($request, self::PARAM_PAGE);
        $products = Product::paginate(2);
        return $products;
    }

    public function getProduct(Request $request) {
        DB::enableQueryLog();
        $id = $this->getParamRouterOrRequest($request, self::PARAM_ID);
        $product = Product::with("category")->find($id);
        Log::info(DB::getQueryLog());
        return $product;
    }


    public function register(Request $request) {
        $resp = $this->validValuesRequest($request);
        if(!$resp) {
            $newProduct = new Product();
            $this->setValuesProductFromRequest($newProduct, $request);
            if(Category::find($newProduct->category_id)) {
                $newProduct->save();

                return $this->sendResponseCreated($newProduct, "Se ha registrado correctamente el producto.");
            } else {
                return $this->sendError("Verifique que la categoría exista.");
            }
        }
        return $resp;
    }

    public function update(Request $request, $id) {
        $resp = $this->validValuesRequest($request);
        if(!$resp) {
            $product = Product::find($id);
            if (!$product) {
                return $this->sendError("No se ha encontrado el producto a actualizar.");
            }
            $this->setValuesProductFromRequest($product, $request);

            if(Category::find($product->category_id)) {
                $product->save();

                return $this->sendResponse($product, "Se ha actualizado el producto correctamente.");
            } else {
                return $this->sendError("Verifique que la categoría exista.");
            }
        }
        return $resp;
    }

    public function delete($id) {
        $product = Product::find($id);
        if (!$product) {
            return $this->sendError("No se ha encontrado el producto a eliminar.");
        }
        $deleted = $product->delete();
        if (!$deleted) {
            return $this->sendError("No se ha podido eliminar el producto " . $product->name);
        }
        return $this->sendResponse($product, "Se ha eliminado el producto correctamente.");
    }

    private function validValuesRequest(Request $request) {
        $valid = ProductValidator::valid($request->all());
        if ($valid->fails()) {
            return $this->sendError("Error en la validación del producto: ", $valid->errors());
        }
    }

    private function setValuesProductFromRequest(Product $product, Request $request) {
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->sku = $request->sku;
        $product->category_id = $request->categoryId;
        return $product;
    }

}
