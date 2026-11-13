<?php

test('suma', function () {
   $result = 1 + 2;
 
   expect($result)->toBe(3);
});

test('comprobar si una persona es mayor de edad', function () {
    $edad = 20;
 
    $esMayor = $edad >= 18;

    expect($esMayor)->toBeTrue();
});

test('comprobar la cantidad de productos', function () {
    $productos = ['pan', 'leche', 'azúcar'];
 
    expect($productos)->toHaveCount(3);
});

function calcularDescuento ($precio, $descuento) {
    return $precio - ($precio * ($descuento / 100));
}

test('calcular descuento', function () {
    $resultado = calcularDescuento(200, 10);

    expect($resultado)->toEqual(180);
});

test('calcular descuento de estudiante', function () {
    $resultado = calcularDescuento(200, 50);

    expect($resultado)->toEqual(100);
});

test('calcular descuento de profesor', function () {
    $resultado = calcularDescuento(200, 0);

    expect($resultado)->toEqual(200);
}); 

test('calcular diferentes descuentos', function ($precio, $descuento, $esperado) {
    $resultado = calcularDescuento($precio, $descuento);

    expect($resultado)->toEqual($esperado);
}) ->with([
    'Descuento de 10%' => [200, 10, 180],
    'Descuento de 50%' => [200, 50, 100],
    'Sin descuento' => [200, 0, 200],
]);