@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Pesquisar clientes</h1>
    <form class="border rounded-4 p-3" action="{{ route('customers.index') }}" method="get">
        <div class="row">
            <div class="col-md-3">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" class="form-control" placeholder="000.000.000-00" onkeyup="mascaraCpf(this);" maxlength="14">
            </div>
            <div class="col-md-3">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Digite o nome do cliente">
            </div>
            <div class="col-md-3">
                <label for="birth_date">Data de Nascimento</label>
                <input type="date" name="birth_date" id="birth_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Sexo</label>
                <div>
                    <label class="me-3"><input type="radio" name="gender" value="M"> Masculino</label>
                    <label><input type="radio" name="gender" value="F"> Feminino</label>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <label for="state">Estado</label>
                <select name="state" id="state" class="form-control">
                    <option value="">Selecione o Estado</option>
                    <option value="SP">São Paulo</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="PR">Paraná</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="RS">Rio Grande do Sul</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="city">Cidade</label>
                <select name="city" id="city" class="form-control">
                    <option value="">Selecione uma cidade</option>
                    <option value="São Paulo">São Paulo</option>
                    <option value="Santo André">Santo André</option>
                    <option value="São Bernardo do Campo">São Bernardo do Campo</option>
                    <option value="Guarulhos">Guarulhos</option>
                    <option value="Rio de Janeiro">Rio de Janeiro</option>
                    <option value="Niterói">Niterói</option>
                    <option value="Duque de Caxias">Duque de Caxias</option>
                    <option value="Nova Iguaçu">Nova Iguaçu</option>
                    <option value="Curitiba">Curitiba</option>
                    <option value="Londrina">Londrina</option>
                    <option value="Maringá">Maringá</option>
                    <option value="Belo Horizonte">Belo Horizonte</option>
                    <option value="Uberlândia">Uberlândia</option>
                    <option value="Contagem">Contagem</option>
                    <option value="Porto Alegre">Porto Alegre</option>
                    <option value="Caxias do Sul">Caxias do Sul</option>
                    <option value="Pelotas">Pelotas</option>
                </select>
            </div>
            <div class="col-md-4 mt-4">
                <button type="submit" class="btn btn-success">Pesquisar</button>
                <button type="reset" class="btn btn-danger">Limpar Busca</button>
            </div>
        </div>
        <a href="{{ route('customers.create') }}" class="btn btn-primary mt-3">Cadastrar um novo cliente</a>
    </form>

    <div class="row mt-5 border rounded-4 p-3">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Data de Nascimento</th>
                        <th>Estado</th>
                        <th>Cidade</th>
                        <th>Sexo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->cpf }}</td>
                            <td>{{ $customer->birth_date->format('d/m/Y') }}</td>
                            <td>{{ $customer->state }}</td>
                            <td>{{ $customer->city }}</td>
                            <td>{{ $customer->gender == 'M' ? 'Masculino' : 'Feminino' }}</td>
                            <td>
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">Editar</a>
                                <button type="button" class="btn btn-danger" onclick="toggleConfirmation('{{ $customer->id }}')">Excluir</button>
                            </td>
                        </tr>
                        <tr id="confirmationRow-{{ $customer->id }}" style="display: none">
                            <td colspan="7" class="text-center" style="background-color: #ffffcc">
                                Tem certeza de que deseja excluir o cliente {{ $customer->name }}?
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline ms-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Sim</button>
                                </form>
                                <button class="btn btn-secondary" onclick="toggleConfirmation('{{ $customer->id }}')">Cancelar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if (count($customers) === 0)
                <div class="alert alert-info">
                    Nenhum cliente foi encontrado.
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script type="text/javascript">
        function toggleConfirmation(id) {
            const row = document.getElementById('confirmationRow-' + id);
            if (row.style.display === 'none') {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }

        function mascaraCpf(input) {
            var cpf = input.value;
            cpf = cpf.replace(/\D/g, ""); // remove qualquer caracter que não seja número
            cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // coloca um ponto depois do terceiro dígito
            cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // coloca um ponto depois do sexto dígito
            cpf = cpf.replace(/(\d{3})(\d{1,2})/, "$1-$2"); // coloca um traço depois do nono dígito
            input.value = cpf;
        }

        document.getElementById('cpf').addEventListener('keyup', function() {
            mascaraCpf(this);
        });
    </script>
@endpush
