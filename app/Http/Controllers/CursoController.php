<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Validator;

class CursoController extends Controller
{
    public function actionCurso()
    {
        // Trae todos los docentes de la BD
        $listCursos = Curso::all();

        // Retorna la vista correcta y pasa la variable correcta
        return view('curso.index', compact('listCursos')); 
    }

    public function actionInsert(Request $request, SessionManager $sessionManager)
    {
        if ($request->isMethod('post')) {
            $listMessage = [];

            // ✅ VALIDACIÓN: Aseguramos que el nombre no esté vacío y sea único
            $validator = Validator::make(
                [
                    'nomCurso' => trim($request->input('txtNombre')),
                ],
                [
                    'nomCurso' => 'required|string|max:100|unique:cursos,nomCurso',
                ],
                [
                    'nomCurso.required' => 'El campo "Nombre" es requerido.',
                    'nomCurso.unique'   => 'El curso ya existe en la base de datos.',
                ]
            );

            if ($validator->fails()) {
                $listMessage = $validator->errors()->all();

                $sessionManager->flash('listMessage', $listMessage);
                $sessionManager->flash('typeMessage', 'error');
                return redirect('curso/insertCurso')->withInput();
            }

            // ✅ Si pasó la validación, insertamos el curso
            $curso = new Curso();
            $curso->idcurso = uniqid(); // Genera un ID único
            $curso->nomCurso = $request->input('txtNombre');
            $curso->estadoCurso = true;
            $curso->save();

            $sessionManager->flash('listMessage', ['Registro realizado correctamente.']);
            $sessionManager->flash('typeMessage', 'success');

            return redirect('curso/');
        }

        return view('curso.insertCurso'); // Vista del formulario
    }

    //funcion para actualizar
    public function actionUpdate($idCurso, Request $request, SessionManager $sessionManager)
	{
		if (!$request->isMethod('post')) {
			return redirect()->route('curso.edit', ['id' => $idCurso]);
		}

		// Validación de los 4 campos
		$validator = Validator::make(
			$request->all(),
			[
				'txtNombre'     => 'required|string|max:100',
			],
			[
				'txtNombre.required'     => 'El campo "Nombre" es requerido.',
			]
		);

		if ($validator->fails()) {
			// Si es AJAX → JSON
			if ($request->ajax()) {
				return response()->json([
					'success' => false,
					'errors'  => $validator->errors()->all()
				], 422);
			}

			// Si no es AJAX → flash messages
			$sessionManager->flash('listMessage', $validator->errors()->all());
			$sessionManager->flash('typeMessage', 'error');
			return redirect()->route('curso.edit', ['id' => $idCurso])->withInput();
		}

		// Buscar alumno y actualizar
		$curso = Curso::findOrFail($idCurso);
		$curso->update([
			'nomCurso' => trim($request->input('txtNombre')),
		]);

			if ($request->ajax()) {
			return response()->json([
				'success' => true,
				'message' => 'Actualización realizada correctamente.'
			]);
		}

		$sessionManager->flash('listMessage', ['Actualización realizada correctamente.']);
		$sessionManager->flash('typeMessage', 'success');
		return redirect()->route('curso.index');
	}

    //Editar el estado 
    public function actionEstado(Request $request, $idCurso)
    {
        $curso = Curso::where('idcurso', $idCurso)->first();
        if (!$curso) {
            return response()->json(['success' => false, 'message' => 'Curso no encontrado.']);
        }

        $curso->estadoCurso = $request->input('estado') == "1" ? true : false;
        $curso->save();

        return response()->json(['success' => true]);
    }


    //ELIMINAR CURSO
    public function actionDelete($idCurso, SessionManager $sessionManager)
	{
		$tCurso = Curso::find($idCurso);

		if ($tCurso) {
			$tCurso->delete();
			if (request()->ajax()) {
				return response()->json(['status' => 'success']);
			}
			$sessionManager->flash('listMessage', ['Registro eliminado correctamente.']);
		}

		return redirect('curso/insertCurso');
	}
}
