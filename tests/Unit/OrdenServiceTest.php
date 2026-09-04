<?php

namespace Tests\Unit;

use App\DTO\StoreOrdenDTO;
use App\Services\OrdenService;
use PHPUnit\Framework\TestCase;
use stdClass;

class OrdenServiceTest extends TestCase
{
    private function data(int $precio_producto, int $cantidad_producto): stdClass
    {
        # Crear el Producto
        $producto = new stdClass();
        $producto->precio_producto = $precio_producto;

        # Crear el Item y asociarle el producto
        $item = new stdClass();
        $item->cantidad_producto = $cantidad_producto;
        $item->precio_unitario = $precio_producto;
        $item->producto = $producto;

        # Crear el carrito
        $carrito = new stdClass();
        $carrito->carrito_items = [$item];

        return $carrito;
    }

    # FUNCION PARA PROBAR EL CALCULO DE TOTALES
    public function test_calcular_totales()
    {
        # ARRANGE: GENERAMOS UN CARRITO ($1000 x 5 = $5000)
        $carrito = $this->data(1000, 5);
        $ordenService = new OrdenService();

        # ACT: EJECUTAMOS LA FUNCION DE CALCULO
        $totales = $ordenService->calcularTotales($carrito);

        # ASSERT: VERIFICAMOS QUE LOS TOTALES SEAN CORRECTOS
        $this->assertEquals([
            'subtotal' => 5000,
            'impuestos' => 1050,
            'costo_envio' => 1500,
            'total' => 7550
        ], $totales);
    }

    # FUNCION PARA COMPROBAR SI EL ENVIO ES GRATIS CUANDO EL CASO LIMITE DE 10000
    public function test_calcular_totales_envio_gratis_desde_monto_limite()
    {
        # ARRANGE: GENERAR UN CARRITO DE 10000
        $carrito = $this->data(1000, 10);
        $ordenService = new OrdenService();
        
        #ACT: EJECUTAMOS LA FUNCION DE CALCULO
        $totales = $ordenService->calcularTotales($carrito);

        # ASSERT: VERIFICAMOS QUE EL COSTO DE ENVIO SEA 0 Y SU TOTAL SEA 12100
        $this->assertEquals(0.0, $totales['costo_envio']);
        $this->assertEquals(12100.0, $totales['total']);
    }

    # FUNCION PARA COMPROBAR SUMA DE TOTALES CON VARIOS ITEMS ANTES DE CALULAR IMPUESTOS
    public function test_calcular_totales_varios_items()
    {
        $carrito = new stdClass();
        $carrito->carrito_items = [
            $this->data(1000, 5)->carrito_items[0],
            $this->data(500, 2)->carrito_items[0]
        ];

        $totales = (new OrdenService())->calcularTotales($carrito);

        $this->assertEquals(6000, $totales['subtotal']);
        $this->assertEquals(1260, $totales['impuestos']);
        $this->assertEquals(8760, $totales['total']);
    }
}
