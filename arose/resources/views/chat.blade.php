@extends('layouts.app')

@section('content')

@php
$conversationId = Request::query('conversation_id');
$user = \Auth::user();
// dd($user->isadmin);
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="mb-2 col-md-3">
          <chat-conversations></chat-conversations>
        </div>
        <div class="mb-2 col-md-6">
          <div class="card card-default">
            <div class="card-header">Conversations</div>
            <div class="card-body">
              @if ($conversationId == 1)
                <h4>Offtopic</h4>
              @else
                <h4>Conversation #{{ $conversationId - 1 }}</h4>
              @endif
              <hr/>
              <div class="container chats">
                  <div class="row">
                      <div class="col-md-12">
                              @if($conversationId)
                              <div class="w-100 py-2">
                                  <chat-messages :conversation="{{ $conversationId }}"></chat-messages>
                              </div>
                              <div class="w-100">
                                  <chat-form
                                          :conversation="{{ $conversationId }}"
                                          :user="{{ auth()->user() }}"
                                  ></chat-form>
                              </div>
                              @endif
                      </div>
                    </div>
                </div>
              </div>
          </div>
        </div>
        <div class="mb-2 col-md-3">
          @if($conversationId)
          <conversation-participants :conversation="{{ $conversationId }}"></conversation-participants>
          @endif
        </div>
    </div>
</div>
@endsection
