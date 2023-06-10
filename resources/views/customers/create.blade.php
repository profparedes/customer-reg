@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Cadastrar um novo cliente</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form class="border rounded-4 p-3" action="{{ route('customers.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" class="form-control" placeholder="000.000.000-00" onkeyup="mascaraCpf(this);" maxlength="14" required>
            </div>
            <div class="col-md-3">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Digite o nome do cliente" required>
            </div>
            <div class="col-md-3">
                <label for="birth_date">Data de Nascimento</label>
                <input type="date" name="birth_date" id="birth_date" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Sexo</label>
                <div>
                    <label class="me-3"><input type="radio" name="gender" value="M" required> Masculino</label>
                    <label><input type="radio" name="gender" value="F" required> Feminino</label>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <label for="address">Endereço</label>
                <input type="text" name="address" id="address" class="form-control" placeholder="Digite o endereço do cliente" required>
            </div>
            <div class="col-md-4">
                <label for="state">Estado</label>
                <select name="state" id="state" class="form-control" required>
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
                <select name="city" id="city" class="form-control" required>
                    <option value="">Selecione o Estado primeiro</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <button type="submit" class="btn btn-success">Salvar</button>
                <button type="reset" class="btn btn-danger">Limpar</button>
                <a href="{{ route('customers.index') }}" class="btn btn-primary">Pesquisar clientes</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">

        var cidadesPorEstado = {
            'SP': ['São Paulo', 'Santo André', 'São Bernardo do Campo', 'Guarulhos'],
            'RJ': ['Rio de Janeiro', 'Niterói', 'Duque de Caxias', 'Nova Iguaçu'],
            'PR': ['Curitiba', 'Londrina', 'Maringá'],
            'MG': ['Belo Horizonte', 'Uberlândia', 'Contagem'],
            'RS': ['Porto Alegre', 'Caxias do Sul', 'Pelotas']
        };

        function atualizarCidades() {
            var estadoSelecionado = document.getElementById('state').value;
            var dropdownCidades = document.getElementById('city');

            dropdownCidades.innerHTML = '';

            if (estadoSelecionado !== '') {
                var cidades = cidadesPorEstado[estadoSelecionado];

                for (var i = 0; i < cidades.length; i++) {
                    var option = document.createElement('option');
                    option.value = cidades[i];
                    option.text = cidades[i];
                    dropdownCidades.appendChild(option);
                }

                dropdownCidades.disabled = false;
            } else {
                dropdownCidades.disabled = true;
                var option = document.createElement('option');
                option.value = '';
                option.text = 'Selecione o Estado primeiro';
                dropdownCidades.appendChild(option);
            }
        }

        document.getElementById('state').addEventListener('change', atualizarCidades);

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
