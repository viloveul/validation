
# Installation

make sure your php version > 7.0

```bash
composer require viloveul/validation
```

## HOW

```php
require __DIR__ . '/vendor/autoload.php';

class UserValidation extends Viloveul\Validation\Validator
{
    public function rules(): array {
        return [
            'insert' => [
                'username' => [
                    'required',
                    ['lengthMin', 5],
                    ['lengthMax', 250],
                    ['notIn', ['admin']],
                    'slug'
                ],
                'email' => [
                    'required',
                    'email',
                    ['lengthMax', 250],
                ],
                'password' => [
                    'required',
                    ['lengthMin', 6],
                    ['equals', 'passconf'],
                ],
                'passconf' => [
                    'required',
                ],
            ],
            'login' => [
                'username' => [
                    'required',
                ],
                'password' => [
                    'required',
                ],
            ],
        ];
    }
}

$validation = new UserValidation($_POST);
if ($validation->validate('login') === false) {
    var_dump($validation->errors());
}

```
