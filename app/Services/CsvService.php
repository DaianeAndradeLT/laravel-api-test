<?php

namespace App\Services;

use App\Models\Product;

class CsvService
{
    public static function import($file): array
    {
        if (empty($file)) {
            return self::generateResponse(false, ["O arquivo não foi fornecido."]);
        }

        $extension = $file->getClientOriginalExtension();
        if ($extension != 'csv') {
            return self::generateResponse(false, ["O arquivo fornecido não é um arquivo CSV válido."]);
        }

        $path = $file->getRealPath();

        $file = fopen($path, 'r');
        if (!$file) {
            return self::generateResponse(false, ["Não foi possível abrir o arquivo CSV."]);
        }

        $header = fgetcsv($file);
        if (!$header) {
            fclose($file);
            return self::generateResponse(false, ["Não foi possível ler o cabeçalho do arquivo CSV."]);
        }

        $errors = [];
        $importedProducts = [];

        while ($row = fgetcsv($file)) {
            $data = array_combine($header, $row);

            $requiredColumns = ['title', 'price', 'description', 'category', 'image'];
            foreach ($requiredColumns as $column) {
                if (!isset($data[$column])) {
                    $errors[] = "A coluna '$column' está ausente em uma linha do arquivo CSV.";
                }
            }

            if (!empty($errors)) {
                continue;
            }

            $data['description'] = substr($data['description'], 0, 200);
            $product = [
                'title' => $data['title'],
                'price' => $data['price'],
                'description' => $data['description'],
                'category' => $data['category'],
                'image' => $data['image'],
            ];

            try {
                $product = Product::create($product);
                $importedProducts[] = $product;
            } catch (\Exception $e) {
                $errors[] = "Erro ao criar o produto: " . $e->getMessage();
            }
        }

        fclose($file);

        if (!empty($errors)) {
            return self::generateResponse(false, $errors);
        } else {
            return self::generateResponse(true, $importedProducts);
        }
    }

    private static function generateResponse(bool $success, array $data): array
    {
        return ['success' => $success, 'errors' => $data];
    }

    public static function export($products): string
    {
        $file = tempnam(sys_get_temp_dir(), 'products_');
        $file = $file . '.csv';

        $csv = fopen($file, 'w');
        fputcsv($csv, ['title', 'price', 'description', 'category', 'image', 'external_id']);

        foreach ($products as $product) {
            fputcsv($csv, [
                $product->title,
                $product->price,
                $product->description,
                $product->category,
                $product->image,
                $product->external_id,
            ]);
        }

        fclose($csv);

        return $file;
    }

}
