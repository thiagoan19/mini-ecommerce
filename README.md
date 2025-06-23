# 🛍️ Mini E-commerce

Projeto fullstack de um mini-e-commerce com **Laravel (API REST)** no back-end e **Nuxt 3** no front-end. Possui listagem de produtos, página de detalhes, carrinho funcional com persistência, responsividade, filtros por categoria e feedbacks visuais com Toast.

---

## 📦 Tecnologias

- **Back-end:** Laravel 11 (PHP), API REST
- **Front-end:** Nuxt 3, Vue 3, Pinia, Vue Toastification
- **Estilo:** CSS customizado com media queries responsivas (style.css)
- **Banco de dados:** SQLite
- **Arquitetura:** Service + Repository + DTOs (Laravel)
- **Outros:** localStorage, axios/fetch, Composables

---

## ⚙️ Como rodar localmente

### Pré-requisitos

- PHP 8.3+, Composer
- Node.js 18+
- SQLite (ou outro banco adaptado)

### Setup completo

```bash
# Clone o repositório
git clone https://github.com/seuusuario/mini-ecommerce.git
cd mini-ecommerce

# BACKEND (Laravel)
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve --host=127.0.0.1 --port=8000 #rode o comando por completo caso apareça erro de proxy
# A API estará rodando em http://127.0.0.1:8000/api/products

# FRONTEND (Nuxt 3)
cd ../frontend
npm install
npm run dev
# A aplicação estará em http://localhost:3000
```

---

## 🔁 Principais rotas

### API REST Laravel

- `GET /api/products` → Lista todos os produtos
- `GET /api/products?category=electronics` → Lista por categoria
- `GET /api/products/{id}` → Detalhes do produto

### SPA Nuxt

- `/` → Página inicial com lista e filtros
- `/products/:id` → Página de detalhes
- `/cart` → Carrinho com ajuste de quantidade e limpeza

---

## 🎯 Funcionalidades

- ✅ Listagem de produtos com filtros por categoria
- ✅ Página de produto com imagem, descrição e botão de adicionar
- ✅ Carrinho com ajuste de quantidade, total e botão de limpar
- ✅ Persistência de carrinho via `localStorage`
- ✅ Feedbacks visuais com Toast (vue-toastification)
- ✅ Layout responsivo com CSS personalizado (iPhone, tablet, desktop)

---

## ⚒️ Decisões técnicas

- **Responsividade** feita sem Tailwind, via `style.css` com media queries globais
- **Persistência de carrinho** via Pinia + `localStorage` sincronizado em `onMounted`
- **Toast** global via `vue-toastification` para avisos de ações do usuário
- **Backend desacoplado** com importação da Fake Store API + camadas (Services, DTOs)
- **Componentes desacoplados** e arquitetura limpa

---

## 🧪 Como testar

- Navegue pelo site e filtre produtos por categoria
- Clique em um produto e tente adicioná-lo ao carrinho
- Altere a quantidade no carrinho, remova e limpe
- Dê F5 e veja se o carrinho persiste
- Verifique toasts e responsividade no navegador

---

## 📁 Estrutura de diretórios

```
mini-ecommerce/
├── ecommerce-backend/         # Projeto Laravel (API REST)
└── ecommerce-frontend/        # Projeto Nuxt 3 (SPA)
```

---

## 📝 Licença

Este projeto é livre para fins educacionais.
