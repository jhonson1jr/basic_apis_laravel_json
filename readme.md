### APIs Laravel 5.8 com processamentos Json

### Necessários: Composer, laravel, php 7, APIs, PostMan ou Insomnia

### Instruções

Baixar o projeto

Dentro do diretório raiz do projeto, abrir o prompt de comando e executar:

```
composer update
```

No prompt, caso seja preciso gerar chave para o projeto, executar:

```
php artisan key:generate
```

Executado a sequência acima, execute o projeto:
```
php artisan serve
```

### Rotas e modelos de requisição

Rota padrao:<br>
GET: http://127.0.0.1:8000/api/
<br><br>
Listagem de instituições:<br>
GET: http://127.0.0.1:8000/api/getinstituicoes
<br><br>
Listagem de convênios:<br>
GET: http://127.0.0.1:8000/api/getconvenios
<br><br>
Realizar simulação de crédito:<br>
POST: http://127.0.0.1:8000/api/simulacao
<br><br>
Modelo de requisição (lembrando que os parâmetros "instituicoes, convenios e parcelas" são opcionais)<br><br>
No Header da requisição json, colocar os atributos:<br>
```
Accept : application/json<br>
Content-Type : application/json<br><br>
```
```
{
	"valor_emprestimo" : 100,
	"instituicoes" : [
		"BMG",
		"PAN"
	],
	"convenios" : [
		"INSS",
		"FEDERAL"
	],
	"parcelas" : 72
}
```
