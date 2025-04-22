<x-app-layout>
    <div class="game-container">
        <h2 style="color: #f4e2b7">Створи гру "Правда чи брехня"</h2>

        <form method="POST" action="{{ route('truth-or-lie.store') }}" id="game-form">
            @csrf

            <label for="title">Назва гри:</label>
            <x-text-input type="text" name="title" id="title" required />

            <label for="description">Опис гри:</label>
            <x-text-input type="text" name="description" id="description" required />

            <div id="statements-container"></div>

            <div class="footer-buttons">
                <button type="button" class="btn" onclick="goBack()">Back</button>
                <button type="submit" class="btn btn-save">Save</button>
                <button type="button" class="btn btn-delete" onclick="clearForm()">Delete</button>
                <button type="button" class="btn btn-next" onclick="addStatement()">Add Statement</button>
            </div>
        </form>
    </div>

    <script>
        let statementIndex = 0;

        function addStatement() {
            const text = prompt("Введи твердження:");
            if (!text) return;

            const isTrue = confirm("Це правда? Натисни OK для 'Так', Відміна для 'Ні'");

            const container = document.getElementById('statements-container');

            // Показ для користувача
            const preview = document.createElement('div');
            preview.classList.add('statement-box');
            preview.innerText = `${text} (${isTrue ? 'Правда' : 'Брехня'})`;
            container.appendChild(preview);

            // Поля для відправки
            const inputText = document.createElement('input');
            inputText.type = 'hidden';
            inputText.name = `statements[${statementIndex}][statement]`;
            inputText.value = text;
            container.appendChild(inputText);

            const inputTruth = document.createElement('input');
            inputTruth.type = 'hidden';
            inputTruth.name = `statements[${statementIndex}][is_true]`;
            inputTruth.value = isTrue ? 1 : 0;
            container.appendChild(inputTruth);

            statementIndex++;
        }

        function clearForm() {
            document.getElementById('game-form').reset();
            document.getElementById('statements-container').innerHTML = '';
            statementIndex = 0;
        }

        function goBack() {
            window.history.back();
        }
    </script>
</x-app-layout>
