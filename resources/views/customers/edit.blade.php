@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Editar Cliente</h1>

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

    <form class="border rounded-4 p-3" action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-3">
                <label for="cpf">CPF</label>
                <input
                    type="text"
                    name="cpf"
                    id="cpf"
                    class="form-control"
                    placeholder="000.000.000-00"
                    onkeyup="mascaraCpf(this);"
                    value="{{ $customer->cpf }}"
                    maxlength="14"
                >
            </div>
            <div class="col">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $customer->name }}">
            </div>
            <div class="col">
                <label for="birth_date">Data de Nascimento</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ $customer->birth_date }}">
            </div>
            <div class="col">
                <label for="gender">Sexo</label><br>
                <div>
                    <input type="radio" id="male" name="gender" value="M" {{ $customer->gender == 'M' ? 'checked' : '' }}>
                    <label class="me-3" for="male">Masculino</label>
                    <input type="radio" id="female" name="gender" value="F" {{ $customer->gender == 'F' ? 'checked' : '' }}>
                    <label for="female">Feminino</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="address">Endereço</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $customer->address }}">
            </div>
            <div class="col">
                <label for="state">Estado</label>
                <select id="state" name="state" class="form-control">
                    <option value="SP" {{ old('state', $customer->state) == 'SP' ? 'selected' : '' }}>São Paulo</option>
                    <option value="RJ" {{ old('state', $customer->state) == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                    <option value="PR" {{ old('state', $customer->state) == 'PR' ? 'selected' : '' }}>Paraná</option>
                    <option value="MG" {{ old('state', $customer->state) == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                    <option value="RS" {{ old('state', $customer->state) == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                </select>
            </div>
            <div class="col">
                <label for="city">Cidade</label>
                <select id="city" name="city" class="form-control">
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar</button>
        <button type="reset" class="btn btn-secondary mt-3">Limpar</button>
        <a href="{{ route('customers.index') }}" class="btn btn-danger mt-3">Cancelar</a>
    </form>
</div>

@endsection

@push('scripts')
    <script type="text/javascript">
        // Mapear as cidades por estado
        var cidadesPorEstado = {
            'SP': ['São Paulo', 'Santo André', 'São Bernardo do Campo', 'Guarulhos'],
            'RJ': ['Rio de Janeiro', 'Niterói', 'Duque de Caxias', 'Nova Iguaçu'],
            'PR': ['Curitiba', 'Londrina', 'Maringá'],
            'MG': ['Belo Horizonte', 'Uberlândia', 'Contagem'],
            'RS': ['Porto Alegre', 'Caxias do Sul', 'Pelotas']
        };

        // Função para atualizar as opções do dropdown de cidades
        function atualizarCidades() {
            var estadoSelecionado = document.getElementById('state').value;
            var dropdownCidades = document.getElementById('city');

            // Limpar as opções do dropdown de cidades
            dropdownCidades.innerHTML = '';

            if (estadoSelecionado !== '') {
                var cidades = cidadesPorEstado[estadoSelecionado];

                for (var i = 0; i < cidades.length; i++) {
                    var option = document.createElement('option');
                    option.value = cidades[i];
                    option.text = cidades[i];
                    dropdownCidades.appendChild(option);
                }

                // Habilitar o dropdown de cidades
                dropdownCidades.disabled = false;
            } else {
                // Desabilitar e adicionar uma opção de seleção do estado primeiro
                dropdownCidades.disabled = true;
                var option = document.createElement('option');
                option.value = '';
                option.text = 'Selecione o Estado primeiro';
                dropdownCidades.appendChild(option);
            }
        }

        // Atualizar as cidades quando a página for carregada e quando o estado selecionado mudar
        document.addEventListener('DOMContentLoaded', function() {
            atualizarCidades();
            document.getElementById('state').addEventListener('change', atualizarCidades);
        });

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
