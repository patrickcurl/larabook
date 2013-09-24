@extends('layouts.admin')
@section('head')
@stop
@section('content')


<h3>Update Features</h3>
{{ Form::open(array('action' => 'AdminController@postUpdateFeatures','method' => 'post', 'files' => true))}}
<table class="table table-striped">
 <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
      <th>Icon</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <?php $count = 0; ?>

    @foreach($features as $feature)
      <tr>
        <input type="hidden" name="features[{{$count}}][id]" value="{{$feature['id']}}" />
        <input type="hidden" name="features[{{$count}}][icon]" value="{{$feature['icon']}}" />
        <td> <input type="text" name="features[{{$count}}][name]" class="input-medium" placeholder="Feature Name" value="{{$feature['name']}}" /></td>
        <td><input type="text" name="features[{{$count}}][description]" class="input-medium" placeholder="Feature Description" value="{{$feature['descr']}}" /></td>
        <td><img src="{{$feature['icon']}}" style="width:32px;" /><br />
        {{Form::file("files[]", array())}}</td>
        <td><label class="checkbox">
    <input type="checkbox" name="features[{{$count}}][remove]"> Remove
  </label></td>
      </tr>
      <?php $count++; ?>

    @endforeach
<tr><td colspan="4"><button type="submit" class="btn pull-right span4">Update Features</button></td></tr>


  </tbody>
  </table>
  {{ Form::close() }}
  <h3>Add Features</h3>
  <div class="row" >
  {{ Form::open(array('action' => 'AdminController@postAddFeature', 'method' => 'post', 'files' => true)) }}
    <div class="span2">{{Form::text("feature[name]", null, array('placeholder' => 'Name', 'class'=> 'input-medium'))}}</div>
    <div class="span2">{{Form::text("feature[description]", null, array('class'=> 'input-medium'))}}</div>
    <div class="span3 offset1">{{Form::file('feature[file]', array())}}</div>
    <div class="span2">{{Form::submit('Add Feature')}}</div>
    {{ Form::close() }}
</div>
<h3>Update Merchants</h3>
{{ Form::open(array('action' => 'AdminController@postUpdateMerchants', 'method' => 'post', 'files' => true)) }}
<table class="table table-striped">
  <thead>
    <tr>
      <th>Name</th>

      <th>Logo</th>
      <th>Description</th>
      <th>Features</th>
    </tr>
  </thead>
  <tbody>
    @foreach($merchants as $index =>$m)
    <tr>
      <input type="hidden" name="merchants[{{$index}}][id]" value="{{$m->id}}" />
      <td><input type="text" name="merchants[{{$index}}][name]" value="{{$m->name}}" class="input-medium" /></td>
      <td>
        <img src="{{$m->logo_url}}" style="width:90px;" />
        {{Form::file("files[]", array())}}
      </td>

      <td class="span7">{{ Form::textarea("merchants[$index][description]", $m->description, array('class' => "span5", "cols"=>"120")) }}</td>

      <td>
        {? $mFeats = array() ?}
        @foreach($m->features as $i => $f)
          {? $mFeats[$i]['id'] = $f->id; ?}
          {? $mFeats[$i]['name'] = $f->name; ?}
        @endforeach
        @foreach($feats as $f)
          @if(in_array($f, $mFeats))
          <label class="checkbox">
            <input type="checkbox" name="merchants[{{$index}}][features][{{$f['id']}}]" checked='checked'>
            {{$f['name']}}

          </label>
          @else
          <label class="checkbox">
            <input type="checkbox" name="merchants[{{$index}}][features][{{$f['id']}}]">
            {{$f['name']}}

          </label>
          @endif
        @endforeach

      </td>
    </tr>

    @endforeach
    <tr><td colspan="4"><button type="submit" class="btn pull-right span4">Update Merchants</button></td></tr>
  </tbody>
</table>
{{ Form::close() }}
<?php echo $merchants->links(); ?>
@stop

@section('footer')
@stop