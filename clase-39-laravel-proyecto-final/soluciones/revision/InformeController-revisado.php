<?php

// Ejercicio 05: el mismo controlador después de la revisión.
// Cada comentario numerado señala uno de los fallos del original

namespace App\Http\Controllers;

use App\Http\Requests\CursoRequest;
use App\Http\Resources\CursoResource;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class InformeController extends Controller
{
    // 1. Faltaban los tipos de los parámetros y de lo que devuelve cada método
    public function index(Request $request): View
    {
        // 2. Nadie comprobaba los permisos: cualquiera podía ver el informe
        Gate::authorize('ver-panel');

        // 3. ¡Inyección SQL! El texto de la URL iba pegado dentro de la consulta.
        //    Con Eloquent (o con marcadores ?) el valor viaja aparte y no se ejecuta
        $buscar = (string) $request->query('buscar', '');

        // 4. Problema N+1: una consulta por cada curso para la categoría y otra para los alumnos.
        //    Con with() y withCount() son dos consultas en total, haya los cursos que haya
        // 5. Y la búsqueda y la tabla eran dos consultas distintas que hacían casi lo mismo
        $cursos = Curso::with('categoria')
            ->withCount('alumnos')
            ->when($buscar !== '', fn (Builder $consulta) => $consulta->buscar($buscar))
            ->orderBy('titulo')
            ->paginate(20)          // 6. Sin paginar, con miles de cursos la página no carga
            ->withQueryString();

        return view('informes.index', ['cursos' => $cursos, 'buscar' => $buscar]);
    }

    // 7. Route model binding: si el curso no existe, 404 (find() devolvía null y fallaba después)
    public function update(CursoRequest $request, Curso $curso): RedirectResponse
    {
        // 8. $request->all() dejaba guardar CUALQUIER campo (asignación masiva).
        //    El Form Request valida, comprueba permisos (authorize) y validated() solo trae lo permitido
        $curso->update($request->validated());

        // 9. ¡Nunca contraseñas (ni datos personales de más) en el log!
        Log::info('Curso actualizado', ['curso_id' => $curso->id, 'usuario_id' => $request->user()->id]);

        // 10. Un dd() olvidado: en producción, la página se quedaba en blanco con los datos a la vista

        // 11. Usar el nombre de la ruta, no la dirección escrita a mano
        return redirect()->route('informes.index')->with('exito', 'Cambios guardados.');
    }

    public function exportar(): AnonymousResourceCollection
    {
        Gate::authorize('ver-panel');

        // 12. env() fuera de config/ devuelve null cuando la configuración está en caché
        //     (php artisan optimize). Para saber el entorno: app()->environment() o isLocal()
        $limite = app()->isLocal() ? 10 : 1000;

        // 13. Devolver los modelos tal cual publicaba TODAS las columnas y los datos de los alumnos
        //     (correos, teléfonos...). Con un API Resource decidimos qué sale y qué no
        return CursoResource::collection(
            Curso::with('categoria')->withCount('alumnos')->take($limite)->get()
        );
    }
}
