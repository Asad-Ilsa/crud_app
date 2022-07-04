<?php
include "layout/header.php";
require_once "scripts/connection.php";
require_once "scripts/helper.php";

$connect = new Connect();
$tasks = $connect->fetchData("tbl_tasks");

if (count($tasks) > 1 || $tasks[0]['status'] != 'None') {
    $actionFlag = true;
} else {
    $actionFlag = false;
}

$inputData = array();

if (array_key_exists("id", $_GET)) {
    $connect->deleteData("tbl_tasks", $_GET["id"]);
    navigate('/');
}

if (array_key_exists("titleInput", $_POST)) {
    $connect->updateData("tbl_tasks", $_POST["idInput"], $_POST["titleInput"], $_POST["statusInput"]);
    navigate('/');
}

if (isset($_POST["deleteEntireTable"])) {
    $connect->deleteEntireData("tbl_tasks", 1);
}
?>

<div class="container d-flex flex-column justify-content-center align-items-center">
    <div class="d-flex justify-content-between align-items-center" style="width:50%;">
        <h1 class="display-6 py-5">Tasks</h1>
        <div class="d-flex gap-1">
            <button type="button" class="btn btn-outline-dark rounded-circle" style="padding:8px 10px;" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                </svg>
            </button>
            <form action="index.php" method="POST">
                <button type="submit" name="deleteEntireTable" class="btn btn-outline-dark rounded-circle" style="padding:8px 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                    </svg>
                </button>
            </form>
            <form action="scripts/exportData.php" method="POST">
                <button type="submit" name="Export" class="btn btn-outline-dark rounded-circle" style="padding:8px 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
    <table class="table shadow-lg table-hover" style="width:50%;">
        <thead>
            <tr class="table-dark">
                <th scope="col" class="text-center" width="7%">#</th>
                <th scope="col">Task Title</th>
                <th scope="col" class="text-center" width="10%">Status</th>
                <th scope="col" class="text-end <?php echo $actionFlag ? '' : 'd-none'; ?>" width="20%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task) { ?>
                <tr class="<?php echo $task["status"] == 'Completed' ? 'table-success' : 'table-light'; ?>">
                    <th class="text-center" scope="row">
                        <?php echo $task["id"]; ?>
                    </th>
                    <td>
                        <?php echo $task["title"]; ?>
                    </td>
                    <td class="text-center">
                        <?php if ($task['status'] == 'Pending') { ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                            </svg>
                        <?php } ?>
                        <?php if ($task['status'] == 'Completed') { ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z" />
                                <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z" />
                            </svg>
                        <?php } ?>
                    </td>
                    <td class="d-flex gap-1 justify-content-end <?php echo $actionFlag ? '' : 'd-none'; ?>">
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle p-1 d-flex justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#updateTaskModal" data-bs-id="<?php echo $task['id']; ?>" data-bs-title="<?php echo $task['title']; ?>" data-bs-status="<?php echo $task['status']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                            </svg>
                        </button>
                        <a href="?id=<?php echo $task['id']; ?>" class="btn btn-outline-danger btn-sm rounded-circle p-1 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div>
        <form action="scripts/loadFileData.php" method="POST" enctype="multipart/form-data" class="d-flex gap-1 align-items-end">
            <div>
                <label for="fileInput" class="form-label">Load Data from file</label>
                <input class="form-control form-control-sm" id="fileInput" name="fileInput" type="file">
            </div>
            <div>
                <button type="submit" name="Import" class="btn btn-primary btn-sm">Save Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                <button id="closeBtn" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="scripts/insertData.php" method="POST">
                    <div id="inputFeilds">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="titleInput0" name="titleInput0" placeholder="task title" required>
                            <label for="titleInput0">Task Title</label>
                        </div>
                    </div>
                    <div class="d-flex gap-1 float-end">
                        <button id="addBtn" type="button" class="btn btn-secondary">Add</button>
                        <button id="saveBtn" type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Task Modal -->
<div class="modal fade" id="updateTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTaskModalLabel">Update Task</h5>
                <button id="closeBtn" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/index.php" method="POST">
                    <div class="form-floating mb-3 d-none">
                        <input type="text" class="form-control" id="idInput" name="idInput" placeholder="task id">
                        <label for="idInput">ID</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="titleInput" name="titleInput" placeholder="task title" required>
                        <label for="titleInput">Task Title</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="statusInput" name="statusInput" aria-label="Task Status Option">
                            <option value="1">Completed</option>
                            <option value="0">Pending</option>
                        </select>
                        <label for="statusInput">Task Status Option</label>
                    </div>
                    <div class="d-flex gap-1 float-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const addBtn = document.getElementById('addBtn')
    const saveBtn = document.getElementById('saveBtn')
    const closeBtn = document.getElementById('closeBtn')

    const target = document.getElementById('inputFeilds')

    let flag = false
    let count = 1

    addBtn.addEventListener('click', (e) => {
        const div = document.createElement('DIV')
        div.classList = "form-floating mb-3"
        const input = document.createElement('INPUT')
        input.type = "text"
        input.classList = "form-control"
        input.setAttribute("id", `titleInput${count}`)
        input.setAttribute("name", `titleInput${count}`)
        input.setAttribute("placeholder", "task title")
        div.appendChild(input)
        const label = document.createElement('LABEL')
        label.setAttribute('for', `titleInput${count}`)
        label.innerText = "Task Title"
        div.appendChild(label)
        target.appendChild(div)
        count++
    })

    const updateTaskModal = document.getElementById('updateTaskModal')
    updateTaskModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget
        const id = button.getAttribute('data-bs-id')
        const title = button.getAttribute('data-bs-title')
        const status = button.getAttribute('data-bs-status')
        const modalTitle = updateTaskModal.querySelector('.modal-title')

        const idInput = updateTaskModal.querySelector('#idInput')
        const titleInput = updateTaskModal.querySelector('#titleInput')
        const statusInput = updateTaskModal.querySelector('#statusInput')

        modalTitle.textContent = `Update Task [id=${id}]`
        idInput.value = id
        titleInput.value = title
        statusInput.value = status == 'Pending' ? 0 : 1
    })
</script>

<?php
include "layout/footer.php"
?>