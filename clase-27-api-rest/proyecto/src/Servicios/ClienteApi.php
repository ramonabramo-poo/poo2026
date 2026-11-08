<?php
declare(strict_types=1);

namespace App\Servicios;

use RuntimeException;

// Un cliente HTTP sencillo con cURL: sirve para NUESTRA API y para cualquier API externa
class ClienteApi
{
    public function __construct(
        private string $urlBase,
        private string $token = "",
        private int $segundosMaximos = 5,
    ) {
    }

    public function get(string $ruta): array
    {
        return $this->peticion("GET", $ruta);
    }

    public function post(string $ruta, array $datos): array
    {
        return $this->peticion("POST", $ruta, $datos);
    }

    public function put(string $ruta, array $datos): array
    {
        return $this->peticion("PUT", $ruta, $datos);
    }

    public function delete(string $ruta): array
    {
        return $this->peticion("DELETE", $ruta);
    }

    // Devuelve ["codigo" => 200, "datos" => [...]] con la respuesta ya convertida desde JSON
    private function peticion(string $metodo, string $ruta, ?array $datos = null): array
    {
        $cabeceras = ["Accept: application/json"];
        if ($this->token !== "") {
            $cabeceras[] = "Authorization: Bearer {$this->token}";
        }

        $curl = curl_init(rtrim($this->urlBase, "/") . $ruta);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);           // devuélveme la respuesta, no la imprimas
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $metodo);         // GET, POST, PUT, DELETE…
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->segundosMaximos);
        if ($datos !== null) {
            $cabeceras[] = "Content-Type: application/json";
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($datos));
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $cabeceras);

        $cuerpo = curl_exec($curl);
        $codigo = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        curl_close($curl);

        if ($cuerpo === false) {
            throw new RuntimeException("No se ha podido conectar con la API: {$error}");
        }

        return ["codigo" => $codigo, "datos" => json_decode($cuerpo, true) ?? []];
    }
}
