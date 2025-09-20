<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class AlumnoController extends Controller
{
	// 📌 Listar alumnos
	public function actionAlumno()
	{
		$listAlumnos = Alumno::all();
		return view('alumno.index', compact('listAlumnos')); // ✅ apunta a resources/views/alumno/index.blade.php
	}

	public function actionInsert(Request $request, SessionManager $sessionManager)
	{
		if ($request->isMethod('post')) {
			$listMessage = [];

			$validator = Validator::make(
				[
					'codAlumno'       => trim($request->input('txtCodigo')),
					'NomAlumno'       => trim($request->input('txtNombre')),
					'AppAlumno'       => trim($request->input('txtAppAlumno')),
					'ApmAlumno'       => trim($request->input('txtApmAlumno')),
					'DNI'             => trim($request->input('txtDNI')),
					'EmailAlumno'     => trim($request->input('txtEmail')),
					'FechaNaciAlumno' => trim($request->input('txtNacimiento')),
					'SexoAlumno'      => trim($request->input('txtSexo')),
					'CiudadAlumno'    => trim($request->input('txtCiudad')),
					'DirAlumno'       => trim($request->input('txtDireccion')),
					'TelAlumno'       => trim($request->input('txtTele')),
				],
				[
					'codAlumno'       => 'required|alpha_num|unique:alumnos,codAlumno',
					'NomAlumno'       => 'required|string|max:50',
					'AppAlumno'       => 'required|string|max:50',
					'ApmAlumno'       => 'required|string|max:50',
					'DNI'             => ['required', 'regex:/^\d{8}$/', 'unique:alumnos,DNI'],
					'EmailAlumno'     => [
						'required',
						'email',
						'unique:alumnos,EmailAlumno',
						'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
					],
					'FechaNaciAlumno' => 'required|date',
					'SexoAlumno'      => 'required|in:M,F,N',
					'CiudadAlumno'    => 'required|string|max:50',
					'DirAlumno'       => 'required|string|max:100',
					'TelAlumno'       => ['required', 'regex:/^\d{9}$/'],
				],
				[
					'codAlumno.required'       => 'El campo "Código" es requerido.',
					'codAlumno.alpha_num'      => 'El código solo puede contener letras y números.',
					'codAlumno.unique'         => 'El código ya existe en la base de datos.',
					'NomAlumno.required'       => 'El campo "Nombre" es requerido.',
					'AppAlumno.required'       => 'El campo "Apellido paterno" es requerido.',
					'ApmAlumno.required'       => 'El campo "Apellido materno" es requerido.',
					'DNI.required'             => 'El campo "DNI" es requerido.',
					'DNI.regex'                => 'El DNI debe contener exactamente 8 números.',
					'DNI.unique'               => 'El DNI ya existe en la base de datos.',
					'EmailAlumno.required'     => 'El campo "Correo electrónico" es requerido.',
					'EmailAlumno.email'        => 'Debe ingresar un correo electrónico válido.',
					'EmailAlumno.unique'       => 'El correo electrónico ya existe en la base de datos.',
					'EmailAlumno.regex'        => 'El correo debe ser una dirección de Gmail válida.',
					'FechaNaciAlumno.required' => 'El campo "Fecha de nacimiento" es requerido.',
					'FechaNaciAlumno.date'     => 'Debe ingresar una fecha válida.',
					'SexoAlumno.required'      => 'El campo "Género" es requerido.',
					'SexoAlumno.in'            => 'El campo "Género" debe ser Masculino (M), Femenino (F) o No especifica (N).',
					'CiudadAlumno.required'    => 'El campo "Ciudad" es requerido.',
					'DirAlumno.required'       => 'El campo "Dirección" es requerido.',
					'TelAlumno.required'       => 'El campo "Número de celular" es requerido.',
					'TelAlumno.regex'          => 'El número de celular debe contener exactamente 9 dígitos.',
				]
			);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				foreach ($errors as $value) {
					$listMessage[] = $value;
				}
			}

			$exists = Alumno::where('codAlumno', $request->input('txtCodigo'))
				->where('NomAlumno', $request->input('txtNombre'))
				->where('AppAlumno', $request->input('txtAppAlumno'))
				->where('ApmAlumno', $request->input('txtApmAlumno'))
				->where('DNI', $request->input('txtDNI'))
				->where('EmailAlumno', $request->input('txtEmail'))
				->where('FechaNaciAlumno', $request->input('txtNacimiento'))
				->where('SexoAlumno', $request->input('txtSexo'))
				->where('CiudadAlumno', $request->input('txtCiudad'))
				->where('DirAlumno', $request->input('txtDireccion'))
				->Where('TelAlumno', $request->input('txtTele'))
				->first();

			if ($exists) {
				$listMessage[] = 'El alumno ya fue registrado con anterioridad.';
			}

			if (count($listMessage) > 0) {
				$sessionManager->flash('listMessage', $listMessage);
				$sessionManager->flash('typeMessage', 'error');
				return redirect('alumno/insert');
			}

			$fechaNacimiento = $request->input('txtNacimiento');
			$fechaFormateada = Carbon::createFromFormat('d/m/Y', $fechaNacimiento)->format('Y-m-d');

			$tAlumno = new Alumno();
			$tAlumno->idAlumno = uniqid();
			$tAlumno->codAlumno = $request->input('txtCodigo');
			$tAlumno->NomAlumno = $request->input('txtNombre');
			$tAlumno->AppAlumno = $request->input('txtAppAlumno');
			$tAlumno->ApmAlumno = $request->input('txtApmAlumno');
			$tAlumno->DNI = $request->input('txtDNI');
			$tAlumno->EmailAlumno = $request->input('txtEmail');
			$tAlumno->FechaNaciAlumno = $fechaFormateada;
			$tAlumno->SexoAlumno = $request->input('txtSexo');
			$tAlumno->CiudadAlumno = $request->input('txtCiudad');
			$tAlumno->DirAlumno = $request->input('txtDireccion');
			$tAlumno->TelAlumno = $request->input('txtTele');
			$tAlumno->save();

			$sessionManager->flash('listMessage', ['Registro realizado correctamente.']);
			$sessionManager->flash('typeMessage', 'success');

			return redirect('alumno/');
		}

		return view('alumno.insert'); // ✅ apunta a resources/views/alumno/insert.blade.php
	}

	public function actionUpdate($idAlumno, Request $request, SessionManager $sessionManager)
	{
		if (!$request->isMethod('post')) {
			return redirect()->route('alumno.edit', ['id' => $idAlumno]);
		}

		// Validación de los 4 campos
		$validator = Validator::make(
			$request->all(),
			[
				'txtNombre'     => 'required|string|max:100',
				'txtAppAlumno'  => 'required|string|max:100',
				'txtApmAlumno'  => 'required|string|max:100',
				'txtTele'       => 'required|string|max:15',
			],
			[
				'txtNombre.required'     => 'El campo "Nombre" es requerido.',
				'txtAppAlumno.required'  => 'El campo "Apellido 1" es requerido.',
				'txtApmAlumno.required'  => 'El campo "Apellido 2" es requerido.',
				'txtTele.required'       => 'El campo "Teléfono" es requerido.',
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
			return redirect()->route('alumno.edit', ['id' => $idAlumno])->withInput();
		}

		// Buscar alumno y actualizar
		$alumno = Alumno::findOrFail($idAlumno);
		$alumno->update([
			'NomAlumno' => trim($request->input('txtNombre')),
			'AppAlumno' => trim($request->input('txtAppAlumno')),
			'ApmAlumno' => trim($request->input('txtApmAlumno')),
			'TelAlumno' => trim($request->input('txtTele')),
		]);

			if ($request->ajax()) {
			return response()->json([
				'success' => true,
				'message' => 'Actualización realizada correctamente.'
			]);
		}

		$sessionManager->flash('listMessage', ['Actualización realizada correctamente.']);
		$sessionManager->flash('typeMessage', 'success');
		return redirect()->route('alumno.index');
	}

	public function actionDelete($idAlumno, SessionManager $sessionManager)
	{
		$tAlumno = Alumno::find($idAlumno);

		if ($tAlumno) {
			$tAlumno->delete();
			if (request()->ajax()) {
				return response()->json(['status' => 'success']);
			}
			$sessionManager->flash('listMessage', ['Registro eliminado correctamente.']);
		}

		return redirect('alumno/insert');
	}
	public function actionEstado(Request $request, $idAlumno)
	{
		$alumno = Alumno::find($idAlumno);
		if (!$alumno) {
			return response()->json(['success' => false, 'message' => 'Alumno no encontrado.']);
		}

		$alumno->ActivoAlumno = $request->estado == "1";
		$alumno->save();

		return response()->json(['success' => true]);
	}
}
