# questionnaire

Requirements:
 * PHP 8.2
 * MySQL 8.0

Run:
 * composer install
 * php bin/console doctrine:database:create
 * php bin/console doctrine:migrations:execute --up 'DoctrineMigrations\Version20231120214754'
 * php bin/console doctrine:fixtures:load

URLs:
  * http://localhost/api/v1/questionnaire [GET]
  * http://localhost/api/v1/questionnaire/{id} [POST] with 
```
{
    "answers": [
        {
            "questionId": 1,
            "answerId": 1
        },
        {
            "questionId": 3,
            "answerId": 3
        }
    ]
}
```
  * http://127.0.0.1:8002/admin
