<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Validators\CategoryValidator;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
{
    private const MSG_ERROR_VALIDATION = "Error en la validación de la categoría: ";

    public function getCategories(Request $request) {
        $request['page'] = Route::current()->parameter("page") ?? $request->get("page");
        $categories = Category::paginate(2);
        return $categories;
    }

    public function getCategory(Request $request) {
        $id = Route::current()->parameter("id") ?? $request->get("id");
        $category = Category::find($id);
        return $category;
    }

    public function register(Request $request) {
        $resp = $this->validValuesRequest($request, null);
        if (!$resp) {
            $newCategory = new Category();
            $this->setValuesCategoryFromRequest($newCategory, $request);
            $newCategory->save();

            $resp = $this->sendResponseCreated($newCategory, "Se ha registrado correctamente la categoría.");
        }
        return $resp;
    }

    public function update(Request $request, $id) {
        $resp = $this->validValuesRequest($request, null);
        if (!$resp) {
            $category = Category::find($id);
            if (!$category) {
                $resp =  $this->sendError("No se ha encontrado la categoría a actualizar.");
            } else {
                $this->setValuesCategoryFromRequest($category, $request);

                $category->save();

                $resp = $this->sendResponse($category, "Se ha actualizado la categoría correctamente.");
            }
        }
        return $resp;
    }

    public function delete($id) {
        $category = Category::find($id);
        if (!$category) {
            return $this->sendError("No se ha encontrado la categoría a eliminar.");
        }
        $deleted = $category->delete();
        if (!$deleted) {
            return $this->sendError("No se ha podido eliminar la categoría " . $category->name);
        }
        return $this->sendResponse($category, "Se ha eliminado la categoría correctamente.");
    }

    private function validValuesRequest(Request $request) {
        $valid = CategoryValidator::valid($request->all());
        if ($valid->fails()) {
            return $this->sendError(self::MSG_ERROR_VALIDATION, $valid->errors());
        }
    }

    private function setValuesCategoryFromRequest(Category $category, Request $request) {
        $category->name = $request->name;
        $category->description = $request->description;
        return $category;
    }

}
