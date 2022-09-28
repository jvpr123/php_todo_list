<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do APP</title>

    {{-- Google Fonts imports --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap" rel="stylesheet">
    
    {{-- CSS imports --}}
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <aside class="side-bar"></aside>
        <div class="content">
            <nav>
                <a href="#" class="btn btn-primary">Criar tarefa</a>
            </nav>

            <main>
                <section class="graph">
                    <div class="graph-header">
                        <h2>Progresso do dia</h2>
                        Data
                    </div>
                    <div class="graph-header-subtitle">
                        Tarefas: <strong>3/6</strong>
                    </div>

                    <div class="graph-placeholder"></div>

                    <p class="graph-tasks-left">Restam 3 tarefas para serem realizadas</p>
                </section>
                <section class="list">
                    <div class="list-header">
                        <select name="" id="" class="list-header-select">
                            <option value="1">Todas as tarefas</option>
                        </select>
                    </div>

                    <div class="tasks-list">
                        <div class="task">
                            <div class="title">
                                <input type="checkbox">
                                <span>Título da tarefa</span>
                            </div>
                            
                            <div class="priority">
                                <div class="sphere"></div>
                                <span>Prioridade</span>
                            </div>

                            <div class="actions">
                                Editar / Excluir
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</body>
</html>