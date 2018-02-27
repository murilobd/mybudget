<template>
	<div class="panel panel-default">
		<div class="panel-heading">Minhas ações</div>

		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped">
					<tr>
						<th>Ação</th>
						<th>Quantidade</th>
						<th>Data da compra</th>
						<th></th>
					</tr>
				</table>
			</div>
		</div>

		<div class="panel-footer">
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-stock-modal">Adicionar ação</button>
		</div>
	</div>
</template>

<script>
	export default {
		mounted() {
			console.log('Component mounted.')
		}
	}
</script>
