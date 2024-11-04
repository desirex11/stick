import { createStore } from 'vuex';

const store = createStore({
  state: {
    player: {
      position: { x: 100, y: 100 }
    }
  },
  mutations: {
    movePlayer(state, { x, y }) {
      state.player.position.x += x;
      state.player.position.y += y;
    }
  }
});

export default store;
