<?php
$columns = $catalog->getColumns();

?>
<style>
table.validate thead > tr > th, 
table.validate tbody > tr > th:first-child
{
	text-align: center;
}
table.validate tbody > tr > td.nouka, 
table.validate tbody > tr > td.baika, 
table.validate tbody > tr > td.stanka
{
	text-align: right;
}
table.validate thead > tr > th.process
{
	width: 30rem;
}
</style>

<?php

?>

<table class="table table-sm table-bordered validate">
  <thead>
    <tr>
      <th>#</th>
      @foreach ($columns as $column)
        <th
          class="{{ $column->name }}"
          data-name="{{ $column->name }}"
          data-title="{{ $column->title }}"
        >
          {{ $column->title }}
        </th>
      @endforeach
      <th class="process">更新の確認</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $index => $data)
    <tr>
      <th scope="row">{{ $index + 1 }}</th>
      @foreach ($columns as $column)
        <?php $value = @$data[$column->name]?>
        <td
          class="{{ $column->name }}"
          data-name="{{ $column->name }}"
          data-title="{{ $column->title }}"
          data-value="{{ $value }}"
        >
          {{ $value }}
        </td>
      @endforeach
      <td class="process"></td>
    </tr>
    @endforeach
  </tbody>
</table>

<script>
$(function ()
{
	// alert('');
});
</script>