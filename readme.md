## how-to 

 * Criar uma cópia do .env.example e renomear a cópia para .env
 * Criar um banco de dados
 * Configurar .env
    - DB_DATABASE=nome_do_banco_criado
    - DB_USERNAME=usuario_banco
    - DB_PASSWORD=senha_banco
 * composer install (necessário instalar composer na máquina, caso não tenha)
 * php artisan key:generate (necessário adicionar o php no path do windows caso de erro de não reconhecer o comando php)
 * php artisan jwt:secret
 * php artisan migrate --seed
 * php artisan serve (necessário para rodar local, irá gerar um link para fazer uso no front das chamadas)