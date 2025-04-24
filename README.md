
# API - Gerenciador de Tarefas

Esta é uma API RESTful para gerenciamento de tarefas, desenvolvida com Laravel 10, PHP 8.2, MySQL e Docker. Inclui autenticação com JWT, atribuição de tarefas, sistema de tags reutilizáveis, envio de notificações por e-mail, e muito mais.

---

## 📦 Requisitos

- Docker
- Docker Compose
- Git (opcional)
- Make (opcional, se for usar `make up` etc)

---

## 🚀 Instalação

### 1. Clone o projeto

```bash
git clone https://github.com/seu-usuario/gerenciador-tarefas-api.git
cd gerenciador-tarefas-api
```

### 2. Crie o `.env`

```bash
cp .env.example .env
```

O arquivo `.env.example` já está preenchido com os dados padrão, incluindo o `JWT_SECRET`:

```env
JWT_SECRET=0bef2a69f32b1974adabee9b8c405581aa00f3e9f701aaa59d4256711ce9b7aa
```

Você pode ajustar conforme necessário.

### 3. Suba os containers

```bash
docker-compose up -d --build
```

### 4. Acesse o container

```bash
docker exec -it laravel-app bash
```

### 5. Instale dependências

```bash
composer install
```

### 6. Rode as migrations

```bash
php artisan migrate
```

---

## 🔐 Autenticação

- JWT via `php-open-source-saver/jwt-auth`
- Para autenticar, envie seu e-mail e senha em `/api/login`
- Use o token JWT no header `Authorization: Bearer {seu_token}` para rotas protegidas

---

## ✉️ E-mails

Utilizamos o [Mailtrap](https://mailtrap.io) para testes:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=ebb3a32954020f
MAIL_PASSWORD=cd183cbbe10343
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=no-reply@gerenciador.com
MAIL_FROM_NAME="Gerenciador de Tarefas"
```

### Para testar e-mails:

1. Rode o worker de fila:
```bash
php artisan queue:work
```

2. Crie uma tarefa com `user_id` de outro usuário para que ele receba uma notificação.

3. Para notificações automáticas (vencimento em 2 dias):

```bash
php artisan notificar:vencimento
```

---

## 🧪 Testando Filtros

- Use a rota POST `/api/tarefas/filtrar` com JSON no body.
- Todos os campos devem estar presentes (podem estar vazios).

```json
{
  "status": "",
  "prioridade": "",
  "user_id": 1,
  "tags": [""],
  "orderby": "",
  "order": ""
}
```

---

## 📋 Funcionalidades

- CRUD de tarefas
- Atribuição de tarefas com e-mail assíncrono
- Sistema de tags reutilizáveis
- Autenticação JWT
- Notificações de vencimento (cron job manual)
- Proteção por usuário responsável/admin
- Filtros e ordenações avançados

---

## ✅ Finalização

Projeto completo e funcional. Qualquer dúvida, entre em contato com o desenvolvedor.

---
