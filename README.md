# Аукцион

### 1.Копируем конфиги окружения

```
cp .env.example .env
cp docker-compose-prod.yml docker-compose.yml
```

### 2.Копируем переменные приложения

```
cp src/.env.example src/.env
```

### 3.Собираем проект

```
docker-compose build
```

### 4.Запускаем проект

```
docker-compose up -d
```

### 5.Доступные экшены

```
GET,POST    /auction/v1/create  создаем аккцион
GET         /auction/v1/view/{UUID}  просмотр аукциона
POST        /auction/v1/run/{UUID}  запуск аукциона
GET,POST    /auction/v1/betting/{UUID}  делаем ставки
```

