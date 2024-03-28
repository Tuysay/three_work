<?php

use PHPUnit\Framework\TestCase;

class CollectTest extends TestCase
{
    public function testCount()
    {
        $collect = new Collect\Collect([13,17]);
        $this->assertSame(2, $collect->count());
    }

    public function testSearch()
    {
        $collect = new Collect\Collect([
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
            ['id' => 3, 'name' => 'Alice']
        ]);
        $result = $collect->search('name', 'Alice')->toArray();
        $this->assertSame([['id' => 1, 'name' => 'Alice'], ['id' => 3, 'name' => 'Alice']], $result);
    }

//Поиск по несуществующему ключу:
    public function testSearchNonExistentKey()
    {
        $collect = new Collect\Collect([
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
            ['id' => 3, 'name' => 'Alice']
        ]);
        $result = $collect->search('age', 25)->toArray();
        $this->assertSame([], $result);
    }

//Проверьте, что unshift метод работает корректно, когда коллекция пуста:
    public function testUnshiftEmptyCollection()
    {
        $collect = new Collect\Collect();
        $collect->unshift(1);
        $this->assertSame([1], $collect->toArray());
    }

//применяет функцию обратного вызова к каждому элементу в коллекции и возвращает новую коллекцию
    public function testMap()
    {
        $collect = new Collect\Collect([1, 2, 3]);
        $result = $collect->map(function ($item) {
            return $item * 2;
        })->toArray();
        $this->assertSame([2, 4, 6], $result);
    }

//Проверьте, что метод map возвращает правильный результат, когда функция обратного вызова возвращает значение, которое не является числом:
    public function testMap_two()
    {
        $collect = new Collect\Collect([1, 2, 3]);
        $result = $collect->map(function ($item) {
            return 'hello';
        })->toArray();
        $this->assertSame(['hello', 'hello', 'hello'], $result);
    }

    public function testPush()
    {
        $collect = new Collect\Collect(['a' => 1, 'b' => 2]);
        $collect->push(3, 'c');
        $this->assertSame(['a' => 1, 'b' => 2, 'c' => 3], $collect->toArray());
    }
//проверка push на пустое поле
    public function testPush_two()
    {
        $collect = new Collect\Collect();
        $collect->push(1);
        $this->assertSame([1], $collect->toArray());
    }


    public function testPushNotEqual()
    {
        $collect = new Collect\Collect(['a' => 1, 'b' => 2]);
        $collect->push(3, 'c');
        $this->assertNotEquals(['a' => 1, 'b' => 2], $collect->toArray());
    }

    public function testPushMultipleItems()
    {
        $collect = new Collect\Collect(['a' => 1, 'b' => 2]);
        $collect->push(['c' => 3, 'd' => 4]);
        $this->assertNotEquals(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], $collect->toArray());
    }

    public function testExceptNotEqual()
    {
        $collect = new Collect\Collect(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertNotEquals(['b' => 3], $collect->except('a', 'c')->toArray());
    }



//Проверьте корректность работы unshift метода, когда коллекция содержит несколько элементов:

    public function testUnshiftMultipleElements()
    {
        $collect = new Collect\Collect([1, 2, 3]);
        $collect->unshift(4, 5);
        $this->assertNotEquals([4, 5, 1, 2, 3], $collect->toArray());
    }

    public function testMapNotEqual()
    {
        $collect = new Collect\Collect([1, 2, 3]);
        $result = $collect->map(function ($item) {
            return $item * 2;
        })->toArray();
        $this->assertNotEquals([1, 2, 3], $result);
    }


    public function testMapChangeOrder()
    {
        $collect = new Collect\Collect([1, 2, 3]);
        $result = $collect->map(function ($item) {
            return $item * 2;
        })->toArray();
        $this->assertEquals([2, 4, 6], $result);
    }


    public function testShiftNotEqual3()
    {
        $collect = new Collect\Collect([1, 2, 3]);
        $collect->shift();
        $this->assertNotEquals([3], $collect->toArray());
    }


//Конечно, вот пример теста, который проверяет, что метод search возвращает пустой массив, если ключ не существует:
    public function testSearchNonExistentKey_emptiness()
    {
        $collect = new Collect\Collect([
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
            ['id' => 3, 'name' => 'Alice']
        ]);
        $result = $collect->search('age', 25)->toArray();
        $this->assertNotEquals([['id' => 1, 'name' => 'Alice']], $result);
        $this->assertNotEquals([['id' => 2, 'name' => 'Bob']], $result);
        $this->assertNotEquals([['id' => 3, 'name' => 'Alice']], $result);
    }






}