<!doctype html>
<html lang="pt_br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CRUD Ajax INC</title>

    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" crossorigin="anonymous">
</head>
<link href="assets/style.css" rel="stylesheet">
<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <form class="form-inline mt-2 mt-md-0" id="clienteSingle">
                    <input class="form-control mr-sm-2" type="text" name="clienteSingle" placeholder="Insira ID ou Email" aria-label="Search">
                    <input value="Procurar" class="btn btn-outline-success my-2 my-sm-0" onclick="getClienteSingle()" />
                </form>
            </div>
        </nav>
    </header>
    <div class="container" style="
    margin-top: 100px;
">
        <h3>CRUD Ajax INC</h3>
        <hr>
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="da">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button class="btn btn-success" data-toggle="modal" data-target="#add_new_record_modal">Adicionar registro</button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="records_content"></div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="add_new_record_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Adicionar registro</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form enctype="multipart/form-data" id="formAdd">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="nome">Nome</label>
                                        <input type="text" id="nome" name="nome" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" name="email" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="senha">Senha</label>
                                        <input type="text" id="senha" name="senha" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="foto">Foto</label>
                                        <input type="file" id="foto" name="foto" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="token">Token</label>
                                        <input type="text" id="token" name="token" class="form-control" value="55148e8eb9d8" required />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" onclick="addRecord()">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Aviso</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
                <script type="text/javascript" src="assets/js/script.js"></script>

            </div>
        </div>

    </div>
    <footer></footer>
    <script src="assets/dist/js/bootstrap.min.js"></script>
</body>
</html>