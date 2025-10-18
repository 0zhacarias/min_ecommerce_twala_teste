# 📦 Mini E-commerce

- Sistema de e-commerce desenvolvido em Laravel com Livewire para teste tendo como duração 72 horas.

## 🛠️ Tecnologias Utilizadas

- **Backend**: Laravel 12.x
- **Frontend**: Livewire, Tailwind CSS
- **Database**: MySQL 8.0
- **Containerização**: Docker & Docker Compose
- 
## 📋 Pré-requisitos

### Ambiente de Desenvolvimento
- **PHP**: 8.2 ou superior
- **Composer**: 2.5 ou superior
- **Node.js**: 18.x ou superior
- **npm**
- **Git**

### Docker (Opcional)
- **Docker**: 20.x ou superior
- **Docker Compose**: 2.x ou superior

## 🚀 Instalação e Configuração

###  1: Desenvolvimento Local (Recomendado para Desenvolvimento)

#### 1. Clonar o Repositório
```bash
git clone https://github.com/@zhacarias/min_ecommerce_twala_teste.git
cd min_ecommerce_twala_teste
```
#### 2. Instalar Dependências 
```
composer install
npm install
npm run dev
```
#### 3. Configurações 
```
DB_CONNECTION=mysql
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```
#### 4. Inicializando Servidor Local 
```
php artisan serve
npm run dev
```
#### 4. Inicializando Servidor Local 
```
php artisan serve
npm run dev
```
### 2. Docker 
#### 1. Subir o Docker 
```
docker-compose up -d
`````
#### 2. Configurando Docker 

```
composer install
npm install && npm run build || npm run dev
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```
#### 3. Parar o Docker 
```
docker-compose down
```
