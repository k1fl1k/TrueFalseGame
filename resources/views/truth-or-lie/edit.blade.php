<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/truth-or-lie-create.css') }}">
    
    <div class="game-container">
        <h2 style="color: #f4e2b7">Редагувати гру "Правда чи брехня"</h2>

        <form method="POST" action="{{ route('truth-or-lie.update', $gameData['id']) }}" id="game-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Назва гри:</label>
                <x-text-input type="text" name="title" id="title" value="{{ $gameData['title'] }}" required />
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Опис гри:</label>
                <x-text-input type="text" name="description" id="description" value="{{ $gameData['description'] }}" required />
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_public">Публічність:</label>
                <div class="flex items-center mt-2">
                    <input type="checkbox" name="is_public" id="is_public" value="1" class="mr-2" {{ $gameData['is_public'] ? 'checked' : '' }}>
                    <label for="is_public" class="cursor-pointer">Зробити гру публічною</label>
                </div>
            </div>

            <div class="statements-header">
                <h3>Твердження <span id="statement-count">(0)</span></h3>
                <button type="button" class="btn btn-add" onclick="openStatementModal()">Додати твердження</button>
            </div>

            @error('statements')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <div id="statements-container" class="statements-list"></div>

            <div class="footer-buttons">
                <button type="button" class="btn" onclick="goBack()">Назад</button>
                <button type="submit" class="btn btn-save" id="save-button">Зберегти</button>
                <button type="button" class="btn btn-delete" onclick="clearForm()">Очистити</button>
            </div>
        </form>
    </div>

    <!-- Modal for adding/editing statements -->
    <div id="statement-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeStatementModal()">&times;</span>
            <h3 id="modal-title">Додати твердження</h3>
            
            <div class="form-group">
                <label for="statement-text">Твердження:</label>
                <textarea id="statement-text" rows="3" class="statement-textarea"></textarea>
                <div id="statement-text-error" class="error-message hidden">Це поле обов'язкове</div>
            </div>
            
            <div class="form-group truth-options">
                <label>Це твердження:</label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="is-true" value="1" checked>
                        <span class="radio-text truth">Правда</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="is-true" value="0">
                        <span class="radio-text lie">Брехня</span>
                    </label>
                </div>
            </div>
            
            <div class="modal-buttons">
                <div class="left-buttons">
                    <button type="button" class="btn btn-delete" id="delete-statement-btn" onclick="deleteCurrentStatement()" style="display: none;">Видалити</button>
                    <div class="delete-hint" id="delete-hint">Підказка: натисніть Delete для видалення</div>
                </div>
                <div class="right-buttons">
                    <button type="button" class="btn btn-cancel" onclick="closeStatementModal()">Скасувати</button>
                    <button type="button" class="btn btn-save" onclick="saveStatement()">Зберегти</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let statementIndex = 0;
        let editingIndex = null;
        let statements = [];
        
        // Завантаження існуючих тверджень з даних гри
        const gameStatements = @json($gameData['statements']);

        // Initialize the form
        document.addEventListener('DOMContentLoaded', function() {
            // Завантаження існуючих тверджень
            if (gameStatements && gameStatements.length > 0) {
                gameStatements.forEach(statement => {
                    statements.push({
                        text: statement.statement,
                        isTrue: statement.is_true === true || statement.is_true === 1
                    });
                });
            }
            
            updateStatementCount();
            checkFormValidity();
            renderStatements(); // Додано для відображення пустого стану при завантаженні

            // Add event listeners for form validation
            document.getElementById('title').addEventListener('input', checkFormValidity);
            document.getElementById('description').addEventListener('input', checkFormValidity);

            // Додати обробник клавіші Delete для видалення твердження
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Delete' && editingIndex !== null && document.getElementById('statement-modal').style.display === 'block') {
                    deleteCurrentStatement();
                }
            });

            // Додати обробник події відправки форми
            document.getElementById('game-form').addEventListener('submit', function(event) {
                console.log('Відправка форми. Твердження:', JSON.parse(JSON.stringify(statements)));

                // Перевірка наявності прихованих полів
                const hiddenInputs = document.querySelectorAll('input[name^="statements["]');
                console.log('Приховані поля форми:', hiddenInputs.length);

                // Перевірка значень прихованих полів
                hiddenInputs.forEach(input => {
                    console.log(`${input.name} = ${input.value}`);
                });
            });
        });

        function openStatementModal(index = null) {
            // Hide error message
            document.getElementById('statement-text-error').classList.add('hidden');

            // Set modal title and values based on whether we're adding or editing
            if (index !== null) {
                // Editing existing statement
                editingIndex = index;
                console.log(`Відкриття редагування твердження №${index}:`, statements[index]);
                document.getElementById('modal-title').textContent = 'Редагувати твердження';
                document.getElementById('statement-text').value = statements[index].text;
                document.querySelector(`input[name="is-true"][value="${statements[index].isTrue ? 1 : 0}"]`).checked = true;
                document.getElementById('delete-hint').style.display = 'block'; // Показати підказку про видалення
                document.getElementById('delete-statement-btn').style.display = 'block'; // Показати кнопку видалення
            } else {
                // Adding new statement
                editingIndex = null;
                document.getElementById('modal-title').textContent = 'Додати твердження';
                document.getElementById('statement-text').value = '';
                document.querySelector('input[name="is-true"][value="1"]').checked = true;
                document.getElementById('delete-hint').style.display = 'none'; // Приховати підказку про видалення
                document.getElementById('delete-statement-btn').style.display = 'none'; // Приховати кнопку видалення
            }

            // Show the modal
            document.getElementById('statement-modal').style.display = 'block';
            document.getElementById('statement-text').focus();
        }

        function closeStatementModal() {
            document.getElementById('statement-modal').style.display = 'none';
        }

        function saveStatement() {
            const text = document.getElementById('statement-text').value.trim();
            if (!text) {
                document.getElementById('statement-text-error').classList.remove('hidden');
                return;
            }

            const isTrue = document.querySelector('input[name="is-true"]:checked').value === '1';

            // Перевірка на дублікати
            let isDuplicate = false;

            if (editingIndex === null) {
                // Перевірка при додаванні нового твердження
                isDuplicate = statements.some(s => s.text === text);
            } else {
                // Перевірка при редагуванні існуючого твердження
                isDuplicate = statements.some((s, idx) => s.text === text && idx !== editingIndex);
            }

            if (isDuplicate) {
                alert('Таке твердження вже існує!');
                return;
            }

            if (editingIndex !== null) {
                // Update existing statement
                console.log(`Редагування твердження №${editingIndex}:`, { text, isTrue });
                const oldText = statements[editingIndex].text;
                const oldIsTrue = statements[editingIndex].isTrue;

                // Перевірка на наявність змін
                if (oldText === text && oldIsTrue === isTrue) {
                    console.log('Твердження не змінилось');
                    closeStatementModal();
                    return;
                }

                statements[editingIndex] = { text, isTrue };
                console.log(`Твердження змінено з "${oldText}" (правда: ${oldIsTrue}) на "${text}" (правда: ${isTrue})`);
                renderStatements();
            } else {
                // Add new statement
                console.log('Додавання нового твердження:', { text, isTrue });
                statements.push({ text, isTrue });
                renderStatements();
            }

            closeStatementModal();
            checkFormValidity();
        }

        function renderStatements() {
            const container = document.getElementById('statements-container');
            container.innerHTML = '';

            // Логування поточного стану тверджень
            console.log('Поточні твердження перед рендерингом:', JSON.parse(JSON.stringify(statements)));

            // Перевірка на дублікати
            const textValues = statements.map(s => s.text);
            const hasDuplicates = textValues.some((text, index) => textValues.indexOf(text) !== index);
            if (hasDuplicates) {
                console.warn('Знайдено дублікати в твердженнях!');
            }

            if (statements.length === 0) {
                const emptyState = document.createElement('div');
                emptyState.className = 'empty-state';
                emptyState.textContent = 'Додайте хоча б одне твердження для створення гри';
                container.appendChild(emptyState);
                return;
            }

            statements.forEach((statement, index) => {
                const statementItem = document.createElement('div');
                statementItem.className = 'statement-item';
                statementItem.dataset.index = index;

                const content = document.createElement('div');
                content.className = 'statement-content';

                const textElement = document.createElement('div');
                textElement.className = 'statement-text';
                textElement.textContent = statement.text;
                content.appendChild(textElement);

                const truthElement = document.createElement('div');
                truthElement.className = 'statement-truth';
                truthElement.innerHTML = statement.isTrue ?
                    '<span class="truth">✓ Правда</span>' :
                    '<span class="lie">✗ Брехня</span>';
                content.appendChild(truthElement);

                const actions = document.createElement('div');
                actions.className = 'statement-actions';

                const editBtn = document.createElement('button');
                editBtn.className = 'action-btn edit-btn';
                editBtn.innerHTML = '✏️';
                editBtn.title = 'Редагувати';
                editBtn.onclick = () => openStatementModal(index);
                actions.appendChild(editBtn);

                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'action-btn delete-btn';
                deleteBtn.innerHTML = '🗑️';
                deleteBtn.title = 'Видалити';
                deleteBtn.onclick = () => deleteStatement(index);
                actions.appendChild(deleteBtn);

                statementItem.appendChild(content);
                statementItem.appendChild(actions);
                container.appendChild(statementItem);

                // Add hidden inputs for form submission
                const inputText = document.createElement('input');
                inputText.type = 'hidden';
                inputText.name = `statements[${index}][statement]`;
                inputText.value = statement.text;
                container.appendChild(inputText);
                console.log(`Створено приховане поле: ${inputText.name} = ${inputText.value}`);

                const inputTruth = document.createElement('input');
                inputTruth.type = 'hidden';
                inputTruth.name = `statements[${index}][is_true]`;
                inputTruth.value = statement.isTrue ? 1 : 0;
                container.appendChild(inputTruth);
                console.log(`Створено приховане поле: ${inputTruth.name} = ${inputTruth.value}`);
            });

            updateStatementCount();
        }

        function deleteStatement(index) {
            if (confirm('Ви впевнені, що хочете видалити це твердження?')) {
                statements.splice(index, 1);
                renderStatements();
                checkFormValidity();
                return true;
            }
            return false;
        }

        function deleteCurrentStatement() {
            if (editingIndex !== null) {
                if (deleteStatement(editingIndex)) {
                    closeStatementModal();
                }
            }
        }

        function updateStatementCount() {
            document.getElementById('statement-count').textContent = `(${statements.length})`;
        }

        function checkFormValidity() {
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            const saveButton = document.getElementById('save-button');

            if (title && description && statements.length > 0) {
                saveButton.disabled = false;
            } else {
                saveButton.disabled = true;
            }
        }

        function clearForm() {
            if (statements.length > 0 && !confirm('Ви впевнені, що хочете очистити всю форму? Всі твердження будуть видалені.')) {
                return;
            }

            document.getElementById('game-form').reset();
            statements = [];
            renderStatements();
            checkFormValidity();
        }

        function goBack() {
            if (statements.length > 0 && !confirm('Ви впевнені, що хочете повернутися назад? Всі незбережені дані будуть втрачені.')) {
                return;
            }
            window.history.back();
        }
    </script>
</x-app-layout>
