<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

// Cargamos Fabricante por que lo usamos más abajo.
use App\Fabricante;

use Response;

class FabricanteController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// return "En el index de Fabricante.";
		// Devolvemos un JSON con todos los fabricantes.
		// return Fabricante::all();

		// Para devolver un JSON con código de respuesta HTTP.
		return response()->json(['status'=>'ok', 'data'=>Fabricante::all()],200);		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	// No se utiliza este método por que se usaría para mostrar un formulario
	// de creación de Fabricantes. Y una API REST no hace eso.
	/*
	public function create()
	{
		//
	}
	*/

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Método llamado al hacer un POST.
		// Comprobamos que recibimos todos los campos.
		if (!$request->input('nombre') || !$request->input('direccion') || !$request->input('telefono'))
		{
			// NO estamos recibiendo los campos necesarios. Devolvemos error.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para procesar el alta.'])],422);
		}

		// Insertamos los datos recibidos en la tabla.
		$nuevoFabricante=Fabricante::create($request->all());

		// Devolvemos la respuesta Http 201 (Created) + los datos del nuevo fabricante + una cabecera de Location + cabecera JSON
		$respuesta= Response::make(json_encode(['data'=>$nuevoFabricante]),201)->header('Location','http://www.dominio.local/fabricantes/'.$nuevoFabricante->id)->header('Content-Type','application/json');
		return $respuesta;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Corresponde con la ruta /fabricantes/{fabricante}
		// Buscamos un fabricante por el ID.
		$fabricante=Fabricante::find($id);

		// Chequeamos si encontró o no el fabricante
		if (! $fabricante)
		{
			// Se devuelve un array errors con los errores detectados y código 404
			return response()->json(['errors'=>Array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])],404);
		}

		// Devolvemos la información encontrada.
		return response()->json(['status'=>'ok','data'=>$fabricante],200);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Borrado de un fabricante.
		// Ejemplo: /fabricantes/89 por DELETE
		// Comprobamos si el fabricante existe o no.
		$fabricante=Fabricante::find($id);

		if (! $fabricante)
		{
			// Devolvemos error codigo http 404
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra el fabricante con ese código.'])],404);
		}

		// Borramos el fabricante y devolvemos código 204
		// 204 significa "No Content".
		// Este código no muestra texto en el body.
		// Si quisiéramos ver el mensaje devolveríamos
		// un código 200.

		$fabricante->delete();

		return response()->json(['code'=>204,'message'=>'Se ha eliminado correctamente el fabricante.'],204);



	}

}
