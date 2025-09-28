<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DocenteController extends Controller
{
        // 📌 Listar docentes
    public function actionDocente()
    {
        // Trae todos los docentes de la BD
        $listDocentes = Docente::all();

        // Retorna la vista correcta y pasa la variable correcta
        return view('docente.index', compact('listDocentes')); 
        // ✅ apunta a resources/views/docente/index.blade.php
    }


    public function actionInsert(Request $request, SessionManager $sessionManager)
    {
        if ($request->isMethod('post')) {
            $listMessage = [];

            $tipoDocumento = trim($request->input('selectTipoDocumento'));
            $numeroDocumento = trim($request->input('txtDocumento'));

            // Reglas de validación
            $rules = [
                'CodigoDocente'         => 'required|alpha_num|unique:docentes,CodigoDocente',
                'NomDocente'            => 'required|string|max:50',
                'AppDocente'            => 'required|string|max:50',
                'ApmDocente'            => 'required|string|max:50',
                'GradoEstudioDocente'   => 'required|string|max:100',
                'emailDocente'          => [
                    'required',
                    'email',
                    'unique:docentes,emailDocente',
                    'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
                ],
                'FechaNacDocente'       => 'required|date',
                'SexoDocente'           => 'required|in:M,F,N',
                'CiudadDocente'         => 'required|string|max:50',
                'DirDocente'            => 'required|string|max:100',
                'NumTelefonoDocente'    => ['required','regex:/^\d{9}$/'],
                'imagDocente'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // ✅ Validación imagen
            ];

            $messages = [
                'GradoEstudioDocente.required' => 'El campo "Grado de estudio" es requerido.',
                'GradoEstudioDocente.string'   => 'El grado de estudio debe ser texto válido.',
                'GradoEstudioDocente.max'      => 'El grado de estudio no puede superar los 100 caracteres.',
                'imagDocente.image'            => 'El archivo debe ser una imagen.',
                'imagDocente.mimes'            => 'La imagen debe ser JPG, JPEG o PNG.',
                'imagDocente.max'              => 'La imagen no debe superar los 2 MB.',
            ];

            // Validación según tipo de documento
            switch ($tipoDocumento) {
                case 'DNI':
                    $rules['DocDocente'] = 'required|regex:/^\d{8}$/|unique:docentes,DocDocente';
                    $messages['DocDocente.regex'] = 'El DNI debe tener exactamente 8 dígitos numéricos.';
                    break;
                case 'PASAPORTE':
                    $rules['DocDocente'] = 'required|regex:/^[A-Z0-9]{6,12}$/i|unique:docentes,DocDocente';
                    $messages['DocDocente.regex'] = 'El Pasaporte debe tener entre 6 y 12 caracteres alfanuméricos.';
                    break;
                case 'CARNET':
                    $rules['DocDocente'] = 'required|regex:/^[A-Z0-9-]{8,15}$/i|unique:docentes,DocDocente';
                    $messages['DocDocente.regex'] = 'El Carnet debe tener entre 8 y 15 caracteres alfanuméricos.';
                    break;
                default:
                    $rules['DocDocente'] = 'required|unique:docentes,DocDocente';
                    $messages['DocDocente.required'] = 'Debe seleccionar un tipo de documento válido.';
            }

            // Validación
            $validator = Validator::make([
                'CodigoDocente'         => $request->input('txtCodigo'),
                'NomDocente'            => $request->input('txtNombre'),
                'AppDocente'            => $request->input('txtAppDocente'),
                'ApmDocente'            => $request->input('txtApmDocente'),
                'GradoEstudioDocente'   => $request->input('txtGradoEstudio'),
                'DocDocente'            => $numeroDocumento,
                'emailDocente'          => $request->input('txtEmail'),
                'FechaNacDocente'       => $request->input('txtNacimiento'),
                'SexoDocente'           => $request->input('txtSexo'),
                'CiudadDocente'         => $request->input('txtCiudad'),
                'DirDocente'            => $request->input('txtDireccion'),
                'NumTelefonoDocente'    => $request->input('txtTele'),
                'imagDocente'           => $request->file('imagDocente'),
            ], $rules, $messages);

            if ($validator->fails()) {
                $listMessage = $validator->errors()->all();
                $sessionManager->flash('listMessage', $listMessage);
                $sessionManager->flash('typeMessage', 'error');
                return redirect('docente/insertDocente');
            }

            $fechaFormateada = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('txtNacimiento'))->format('Y-m-d');

            // ✅ Subida de imagen
            $rutaImagen = null;
            if ($request->hasFile('imagDocente')) {
                $rutaImagen = $request->file('imagDocente')->store('docentes', 'public'); 
            } else {
                // Si no subió imagen, usamos la imagen por defecto
                $rutaImagen = 'images/default.png'; // Debe existir en public/images/
            }

            // Guardar en DB
            Docente::create([
                'idDocente'          => uniqid(),
                'CodigoDocente'      => $request->input('txtCodigo'),
                'DocDocente'         => $numeroDocumento,
                'NomDocente'         => $request->input('txtNombre'),
                'AppDocente'         => $request->input('txtAppDocente'),
                'ApmDocente'         => $request->input('txtApmDocente'),
                'GradoEstudioDocente'=> $request->input('txtGradoEstudio'),
                'FechaNacDocente'    => $fechaFormateada,
                'SexoDocente'        => $request->input('txtSexo'),
                'CiudadDocente'      => $request->input('txtCiudad'),
                'DirDocente'         => $request->input('txtDireccion'),
                'emailDocente'       => $request->input('txtEmail'),
                'NumTelefonoDocente' => $request->input('txtTele'),
                'estadoDocente'      => 1,
                'imagDocente'        => $rutaImagen,
            ]);

            $sessionManager->flash('listMessage', ['Registro de docente realizado correctamente.']);
            $sessionManager->flash('typeMessage', 'success');
            return redirect('docente/');
        }

        return view('docente.insertDocente');
    }

    public function actionUpdate($idDocente, Request $request, SessionManager $sessionManager)
    {
        if (!$request->isMethod('post')) {
            return redirect()->route('docente.edit', ['id' => $idDocente]);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'txtNombre'     => 'required|string|max:100',
                'txtAppDocente' => 'required|string|max:100',
                'txtApmDocente' => 'required|string|max:100',
                'txtTele'       => 'required|string|max:15',
            ]
        );

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors()->all()
                ], 422);
            }
            $sessionManager->flash('listMessage', $validator->errors()->all());
            $sessionManager->flash('typeMessage', 'error');
            return redirect()->route('docente.edit', ['id' => $idDocente])->withInput();
        }

        $docente = Docente::findOrFail($idDocente);

        // ✅ revisar nombre real de la columna
        $docente->NomDocente        = trim($request->input('txtNombre'));
        $docente->AppDocente        = trim($request->input('txtAppDocente'));
        $docente->ApmDocente        = trim($request->input('txtApmDocente'));
        $docente->NumTelefonoDocente = trim($request->input('txtTele')); // 👈 ojo aquí

        // ✅ Imagen
        if ($request->hasFile('txtImagen')) {
            if ($docente->imagDocente && $docente->imagDocente !== 'images/default.png') {
                Storage::disk('public')->delete($docente->imagDocente);
            }
            $path = $request->file('txtImagen')->store('docentes', 'public');
            $docente->imagDocente = $path;
        }

        $docente->save();

        if ($request->ajax()) {
            return response()->json([
                'success'     => true,
                'message'     => 'Docente actualizado correctamente.',
                'newImageUrl' => $docente->imagDocente
                    ? asset('storage/' . $docente->imagDocente)
                    : asset('images/default.png')
            ]);
        }

        $sessionManager->flash('listMessage', ['Actualización realizada correctamente.']);
        $sessionManager->flash('typeMessage', 'success');
        return redirect()->route('docente.index');
    }

    public function actionDelete($idDocente, SessionManager $sessionManager)
	{
		$tDocente = Docente::find($idDocente);

		if ($tDocente) {
			$tDocente->delete();
			if (request()->ajax()) {
				return response()->json(['status' => 'success']);
			}
			$sessionManager->flash('listMessage', ['Registro eliminado correctamente.']);
		}

		return redirect('docente/insert');
	}

    public function actionEstado(Request $request, $idDocente)
    {
        $docente = Docente::find($idDocente);

        if (!$docente) {
            return response()->json(['success' => false, 'message' => 'Docente no encontrado.']);
        }

        // Actualizamos usando el campo correcto
        $docente->estadoDocente = $request->estado == "1" ? 1 : 0;
        $docente->save();

        return response()->json(['success' => true]);
    }


}

