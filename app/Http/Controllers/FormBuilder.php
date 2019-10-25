<?php

namespace App\Http\Controllers;

use App\Form;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormBuilder extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forms = [];

        foreach( DB::table('forms')->orderBy('id', 'desc')->get() as $form ) {
            $forms[] = [
                'id' => $form->id,
                'form_name' => $form->form_name,
                'form_data' => json_decode($form->form_data)
            ];
        }
        return $forms;
        // return view('forms.index', ['forms' => $forms]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = new Form;
        $data = [];
        foreach( $request->fields as $field ) {
            $field_type     = $field['type'];
            $field_value    = $field['value'];
            $field_label    = $field['label'];

            if( $field['type'] == 'upload-field' ) {
                $image = $field['value'];
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                // Changing the field_value for the image field
                $field_value = $name;
                \Image::make($image)->save(public_path('storage/').$name);
            }
            $data [] = [
                'label' => $field_label,
                'type'  => $field_type,
                'value' => $field_value
            ];
        }
        $form->form_name = $request->form_name;
        $form->form_data = json_encode($data);
        $form->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return DB::table('forms')->where('id', '=', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $form = Form::findOrFail($id);
        $data = [];
        foreach( $request->fields as $field ) {
            $field_type     = $field['type'];
            $field_value    = $field['value'];
            $field_label    = $field['label'];

            if( $field['type'] == 'upload-field' ) {
                if( isset($field['changed']) ) {
                    $image = $field['value'];
                    $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                    // Changing the field_value for the image field
                    $field_value = $name;
                    \Image::make($image)->save(public_path('storage/').$name);
                }
            }
            $data []= [
                'label' => $field_label,
                'type'  => $field_type,
                'value' => $field_value
            ];
        }
        $form->form_name = $request->form_name;
        $form->form_data = json_encode($data);
        $form->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('forms')->where('id', '=', $id)->delete();
    }

    /**
     * Generate PDF Form
     */
    public function generate_pdf($id) {
        foreach(DB::table('forms')->where('id', '=', $id)->get() as $item) {
            $data = json_decode($item->form_data);
            $pdf = PDF::loadView('forms.pdf', ['form' => $data]);
        }
        return $pdf->download('pdf.pdf');
    }
}
