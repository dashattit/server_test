<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Model\Readers;

class ReaderControllerTest extends TestCase
{
    #[DataProvider('additionProvider')]
    public function testCreate(string $httpMethod, array $readerData, string $message, int $testNumber): void
    {
        // Создаем заглушку для Request
        $request = $this->createMock(\Src\Request::class);
        $request->expects($this->any())
            ->method('all')
            ->willReturn($readerData);
        $request->method = $httpMethod;

        // Сохраняем результат работы метода
        $result = (new \Controller\ReadersController())->create($request);

        if ($result instanceof \Src\View) {
            $errors = $result->data['errors'] ?? [];
            $errorsAsString = implode(' ', array_map(fn($e) => implode(' ', (array)$e), $errors));
            $this->assertStringContainsString($message, $errorsAsString);
            return;
        }

// Проверяем, что читатель добавился в базу
        $this->assertTrue((bool)Readers::where('telephone', $readerData['telephone'])->count());

        Readers::where('telephone', $readerData['telephone'])->delete();
// Проверяем редирект при успешном создании
        if ($testNumber === 2 || $testNumber === 3) {
            $this->assertContains($message, xdebug_get_headers());
        }

    }

    protected function setUp(): void
    {
        $_SERVER['DOCUMENT_ROOT'] = '../server';

        $GLOBALS['app'] = new Src\Application(new Src\Settings([
            'app' => include $_SERVER['DOCUMENT_ROOT'] . '/config/app.php',
            'db' => include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php',
            'path' => include $_SERVER['DOCUMENT_ROOT'] . '/config/path.php',
        ]));

        if (!function_exists('app')) {
            function app()
            {
                return $GLOBALS['app'];
            }
        }
    }

    // Набор тестовых данных
    public static function additionProvider(): array
    {
        return [
            // GET-запрос
            ['GET', [
                'first_name' => '', 'last_name' => '', 'patronym' => '',
                'address' => '', 'telephone' => ''
            ], '', 1],

            // POST с корректными данными → редирект
            ['POST', [
                'first_name' => 'Алексей', 'last_name' => 'Иванов', 'patronym' => 'Сергеевич',
                'address' => 'г. Томск, ул. Иркутский тракт, 102', 'telephone' => '89134450835'
            ], 'Location: /server/readers', 2],

            // POST с заполнением только обязательных полей → редирект
            ['POST', [
                'first_name' => 'Алексей', 'last_name' => 'Иванов', 'patronym' => '',
                'address' => 'г. Томск, ул. Иркутский тракт, 102', 'telephone' => '89134450835'
            ], 'Location: /server/readers', 3],

            // POST без данных → ошибка
            ['POST', [
                'first_name' => '', 'last_name' => '', 'patronym' => '',
                'address' => '', 'telephone' => ''
            ], 'Поле first_name пусто', 4],

            // POST с существующими данными → ошибка
            ['POST', [
                'first_name' => 'Алексей', 'last_name' => 'Иванов', 'patronym' => 'Сергеевич',
                'full_name' => 'Иванов Алексей Сергеевич', 'address' => 'г. Томск, ул. Иркутский тракт, 102', 'telephone' => '89134450835'
            ], 'Читатель с таким ФИО уже существует', 5],
        ];

    }
}