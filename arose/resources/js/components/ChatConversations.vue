<template>
  <div class="card card-default">
    <div class="card-header">Conversations</div>
    <div class="card-body">
      <span v-if="isAdmin">
      <button class="btn btn-primary btn-sm" @click="createConversation()">New Conversation</button>
      <br />
      <br />
      </span>
      <ul class="conversation">
        <li class="clearfix py-2 border-bottom" v-for="(convo, index) in conversations" :key="index">
          <div class="chat-body clearfix">
            <div class="header">
              <a href="#" @click="showConversation(convo.id)">
                <strong class="primary-font" v-if="convo.id === 1">Offtopic</strong>
                <strong class="primary-font" v-else>Conversation {{ convo.id - 1 }}</strong>
              </a>
              <a
                v-if="!isParticipant(convo.id)"
                href="#"
                class="text-success"
                @click="joinConversation(convo.id)"
              >
                 | <strong>Join</strong>
              </a>
              <a
                v-else
                href="#"
                class="text-danger"
                title="leave conversation"
                @click="leaveConversation(convo.id)"
              >
                <strong>Leave</strong>
              </a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    conversation: null,
    conversations: []
  }),

  props: ["messages"],

  computed: {
      isAdmin() {
          return window.isAdmin === 1;
      }
  },

  methods: {
    createConversation() {
      axios.post("/chat/conversations").then(response => {
        location.reload();
      });
    },

    fetchConversations() {
      axios.get("/chat/conversations").then(response => {
        // console.log(response, response.data);
        // window.conversations = response.data;
        this.conversations = response.data;
      });
    },

    showConversation(id) {
      window.location.href = "chat?conversation_id=" + id;
    },

    isParticipant(id) {
      return window.conversations.indexOf(id) !== -1;
    },

    leaveConversation(id) {
      let participationId;
      const convo = this.conversations.find(c => c.id === id);
      // console.log(convo);
      participationId = convo.participants ? convo.participants.find(
        p => p.id == window.participant.id
      ).participation[0]["id"] : convo.id;

      axios
        .delete(`/chat/conversations/${id}/participants/${participationId}`)
        .then(() => {
          window.location.href = "chat?conversation_id=" + id;
        });
    },

    joinConversation(id) {
      const payload = {
        participants: [
          {
            id: window.participant.id,
            type: window.participant.type
          }
        ]
      };

      axios
        .post(`/chat/conversations/${id}/participants`, payload)
        .then(response => {
          window.location.href = "chat?conversation_id=" + id;
        });
    }
  },

  mounted() {
    this.fetchConversations();
  }
};
</script>
<style lang="scss" scoped>
ul.conversation {
    padding: 0;
    list-style: none;
}
</style>
