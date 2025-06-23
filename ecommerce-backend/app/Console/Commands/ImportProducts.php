<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Services\ProductService;
use App\DTOs\ProductDTO;

class ImportProducts extends Command
{
    protected $signature = 'products:import {--id=}';
    protected $description = 'Importa produtos da Fake Store API';

    public function __construct(protected ProductService $service)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $id = $this->option('id');
        $url = $id
            ? "https://fakestoreapi.com/products/{$id}"
            : "https://fakestoreapi.com/products";

        $response = Http::get($url);

        if (!$response->ok()) {
            $this->error("Erro ao acessar a Fake Store API.");
            return Command::FAILURE;
        }

        $data = $response->json();

        // Se importar um único produto, transformar em array
        if ($id) {
            $data = [$data];
        }

        foreach ($data as $item) {
            $dto = new ProductDTO(
                name: $item['title'],
                price: $item['price'],
                description: $item['description'],
                category: $item['category'],
                image_url: $item['image'] ?? null,
            );

            $existing = $this->service->findByName($dto->name);

            if ($existing) {
                $this->service->update($existing, $dto);
                $this->info("Produto atualizado: {$dto->name}");
            } else {
                $this->service->create($dto);
                $this->info("Produto criado: {$dto->name}");
            }
        }

        $this->info("Importação finalizada com sucesso.");
        return Command::SUCCESS;
    }
}
