<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Game</h5>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/game/new" method="post" class="modal-content p-3" id="{{ $id }}-form">
                @csrf

                <label>
                    <input
                        type="checkbox" name="ranked" id="{{$id}}-cbx-ranked" data-toggle="toggle" data-height="60" data-width="100"
                        data-on="<i class='fa-solid fa-trophy fa-beat'></i> Ranked"
                        data-off="<i class='fa-solid fa-dumbbell'></i> Training" class="px-3 py-2"
                        onchange="document.getElementById('{{ $id }}-custom-button').style.display = this.checked ? 'none' : 'block'"
                    />
                    Game type
                </label>


                <input type="hidden" id="{{ $id }}-type" name="game-type" value="none"/>
                <input type="hidden" id="{{ $id }}-custom-w" name="custom-w" value="0"/>
                <input type="hidden" id="{{ $id }}-custom-h" name="custom-h" value="0"/>
                <input type="hidden" id="{{ $id }}-custom-b" name="custom-b" value="0"/>

                <div class="row mt-3">
                    <div class="col-sm my-1">
                        <button
                            onclick="document.getElementById('{{ $id }}-type').value = 'easy'; document.getElementById('{{ $id }}-form').submit()"
                            type="button"
                            class="btn btn-primary btn-lg w-100 h-100">
                            <i class="fa-solid fa-star"></i><br/>Easy
                        </button>
                    </div>
                    <div class="col-sm my-1">
                        <button
                            onclick="document.getElementById('{{ $id }}-type').value = 'normal'; document.getElementById('{{ $id }}-form').submit()"
                            type="button"
                            class="btn btn-primary btn-lg w-100 h-100">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><br/>Normal
                        </button>
                    </div>
                    <div class="col-sm my-1">
                        <button
                            onclick="document.getElementById('{{ $id }}-type').value = 'hard'; document.getElementById('{{ $id }}-form').submit()"
                            type="button"
                            class="btn btn-primary btn-lg w-100 h-100">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><br/>Hard
                        </button>
                    </div>
                    <div class="col-sm my-1" id="{{ $id }}-custom-button">
                        <button
                            data-bs-toggle="modal" data-bs-target="#{{$id}}-custom"
                            onclick="document.getElementById('{{ $id }}-type').value = 'custom';"
                            type="button"
                            class="btn btn-primary btn-lg w-100 h-100 ">
                            <i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i
                                class="fa-regular fa-star"></i><br/>Custom
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="{{ $id }}-custom" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Custom Game</h5>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="{{ $id }}-field-width"> Field Width </label>
                    <input type="number" id="{{ $id }}-field-width" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="{{ $id }}-field-height"> Field Height </label>
                    <input type="number" id="{{ $id }}-field-height" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="{{ $id }}-field-bombs"> Bombs </label>
                    <input type="number" id="{{ $id }}-field-bombs" class="form-control"/>
                </div>
            </div>
            <div id="{{ $id }}-field-preview" class="d-flex flex-column"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abort</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('{{ $id }}-form').submit()">Create Game</button>
            </div>
        </div>

    </div>
</div>

<script>
    const fp = document.getElementById("{{ $id }}-field-preview");

    function genBombs(w, h, b) {
        const ret = Array(w * h).fill(false);
        for (let i = 0; i < b; i++) ret[Math.round(Math.random() * w * h)] = true;
        return ret;
    }

    function genFieldPreview(w, h, b) {
        fp.innerHTML = ''; //clear the preview
        const bombs = genBombs(w, h, b);
        for (let row = 0; row < h; row++) {
            const r = document.createElement('div');
            r.className = 'd-flex flex-row flex-nowrap justify-content-center'
            for (let col = 0; col < w; col++) {
                const c = document.createElement('div');
                c.className = 'field-preview-cell'
                c.style.width = c.style.height = Math.floor(fp.clientWidth / Math.max(w, h)) + "px";
                if(bombs[row*h + col]) c.className += ' bomb'
                r.appendChild(c);
            }
            fp.appendChild(r);
        }
    }

    const size = [0, 10, 10]

    function fieldChanges() {
        document.getElementById('{{$id}}-cbx-ranked').checked = false
        genFieldPreview(...size);
    }

    document.getElementById('{{ $id }}-field-width').addEventListener('keyup', (e) => {
        size[0] = document.getElementById('{{ $id }}-custom-w').value = e.target.value;
        fieldChanges();
    })
    document.getElementById('{{ $id }}-field-height').addEventListener('keyup', (e) => {
        size[1] = document.getElementById('{{ $id }}-custom-h').value = e.target.value;
        fieldChanges();
    })
    document.getElementById('{{ $id }}-field-bombs').addEventListener('keyup', (e) => {
        size[2] = document.getElementById('{{ $id }}-custom-b').value = e.target.value;
        fieldChanges();
    })
</script>
