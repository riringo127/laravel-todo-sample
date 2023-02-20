@extends('layouts.app')
 
 @section('content')
    <div class="container h-100"> 
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- 検索フォーム -->
        <form method="GET" action="{{ route('todos.index')}}">
          <div class="input-group">
               <input type="text" name="search" class="form-control" placeholder="キーワードを入力" value="@if (isset($search)) {{ $search }} @endif">
               <button class="btn btn-outline-secondary"><i class="fas fa-search"></i>検索</button>
               <button class="btn btn-secondary">
                    <a href="{{ route('todos.index') }}" style="text-decoration:none;" class="text-white">
                        クリア
                    </a>
                </button>
          </div>
        </form>
 
        <!-- ToDoの追加用モーダル -->
        @include('modals.add_todo')  
 
        <div class="d-flex my-3">
            <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#addTodoModal">
                <div class="d-flex align-items-center">
                    <span class="fs-5 fw-bold">＋</span>&nbsp;ToDoの追加
                </div>
            </a>          
        </div>  
        
        <div class="row row-cols-1 row row-cols-md-2 row-cols-lg-3 g-4">                         
             @foreach ($todos as $todo) 
             
                <!-- ToDoの編集用モーダル -->
                @include('modals.edit_todo') 
 
                <!-- ToDoの削除用モーダル -->
                @include('modals.delete_todo')  
 
                <div class="col">     
                    <div class="card bg-light">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h4 class="card-title ms-1 mb-0">
                              @if ($todo->done)
                                <s>{{ $todo->content }}</s>
                              @else
                                {{ $todo->content }}
                              @endif
                            </h4>
                            <div class="d-flex align-items-center">                                 
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle px-1 fs-5 fw-bold link-dark text-decoration-none menu-icon" id="dropdownTodoMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">︙</a>
                                    <ul class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="dropdownGoalMenuLink">
                                        <li>
                                          <form action="{{ route('todos.update', $todo) }}" method="post">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="content" value="{{ $todo->content }}">
                                                @if ($todo->done)  
                                                    <input type="hidden" name="done" value="false">
                                                    <button type="submit" class="dropdown-item btn btn-link">未完了</button>
                                                @else
                                                    <input type="hidden" name="done" value="true">
                                                    <button type="submit" class="dropdown-item btn btn-link">完了</button> 
                                                @endif
                                          </form>                                                       
                                        </li>  
                                        <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editTodoModal{{ $todo->id }}">編集</a></li>                                   
                                        <div class="dropdown-divider"></div>
                                        <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteTodoModal{{ $todo->id }}">削除</a></li>                                                                                                          
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>                           
                </div>
            @endforeach                       
        </div>
    </div>
@endsection