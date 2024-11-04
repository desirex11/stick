<template>
  <div class="game-container">
    <div v-for="player in players" :key="player.id" class="player" :style="getPlayerStyle(player)">
      {{ player.name }}
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentPlayerId: null, // The ID of the current player (set when the game loads)
      players: [
        { id: 1, name: 'Player 1', position: { x: 100, y: 100 } },
        { id: 2, name: 'Player 2', position: { x: 200, y: 200 } }
      ],
      movementStep: 10 // Number of pixels to move per key press
    };
  },
  computed: {
    getPlayerStyle() {
      return (player) => ({
        left: `${player.position.x}px`,
        top: `${player.position.y}px`
      });
    }
  },
  methods: {
    handleKeydown(event) {
      // Ensure a current player is set before allowing movement
      if (this.currentPlayerId === null) {
        console.warn('No player ID set. Please set a player ID to start.');
        return;
      }

      const currentPlayer = this.players.find(p => p.id === this.currentPlayerId);
      if (!currentPlayer) {
        console.warn(`Player with ID ${this.currentPlayerId} not found.`);
        return;
      }

      const containerWidth = 800; // Width of the game container
      const containerHeight = 600; // Height of the game container
      const playerSize = 80; // Width and height of the player

      let keyPressed = ''; // Track the key pressed

      switch (event.key) {
        case 'w': // Move up
          if (currentPlayer.position.y > 0) {
            currentPlayer.position.y -= this.movementStep;
            keyPressed = 'w';
          }
          break;
        case 'a': // Move left
          if (currentPlayer.position.x > 0) {
            currentPlayer.position.x -= this.movementStep;
            keyPressed = 'a';
          }
          break;
        case 's': // Move down
          if (currentPlayer.position.y < containerHeight - playerSize) {
            currentPlayer.position.y += this.movementStep;
            keyPressed = 's';
          }
          break;
        case 'd': // Move right
          if (currentPlayer.position.x < containerWidth - playerSize) {
            currentPlayer.position.x += this.movementStep;
            keyPressed = 'd';
          }
          break;
      }

      // Trigger the event if a key was pressed
      if (keyPressed) {
        this.triggerMoveEvent(currentPlayer);
      }
    },
    triggerMoveEvent(player) {
      console.log('Triggering POST request for player move:', player);
      fetch('http://localhost:8000/test-broadcast', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ id: player.id, position: player.position }) // Send actual player data
      })
        .then(response => response.json())
        .then(data => console.log('Broadcast response:', data))
        .catch(error => console.error('Error:', error));
    },
    updatePlayerPosition(data) {
      const playerIndex = this.players.findIndex(p => p.id === data.id);
      if (playerIndex !== -1) {
        // Update position only, do not reinitialize the player
        this.players[playerIndex].position.x = data.position.x;
        this.players[playerIndex].position.y = data.position.y;
        console.log('Player position updated:', this.players[playerIndex]);
      } else {
        // Add a new player if not found
        this.players.push({ id: data.id, name: `Player ${data.id}`, position: data.position });
        console.log('New player added with data:', data);
      }
    }
  },
  mounted() {
    // Prompt the user for their player ID
    const playerId = parseInt(prompt('Enter your Player ID (e.g., 1 or 2):'), 10);
    if (playerId && this.players.find(player => player.id === playerId)) {
      this.currentPlayerId = playerId;
      console.log(`Player ID set to ${this.currentPlayerId}`);
    } else {
      alert('Invalid Player ID. Defaulting to Player 1.');
      this.currentPlayerId = 1; // Default to Player 1 if input is invalid
    }

    window.addEventListener('keydown', this.handleKeydown);

    // Listen for updates from the server and sync player positions
    window.Echo.channel('game-channel')
      .listen('.player-moved', (data) => {
        console.log('Received broadcast:', data);
        this.updatePlayerPosition(data);
      });
  },
  beforeUnmount() {
    window.removeEventListener('keydown', this.handleKeydown);
  }
};
</script>

<style scoped>
.game-container {
  position: relative;
  width: 800px;
  height: 600px;
  border: 1px solid #000;
  background-color: #f0f0f0;
background-image: url('/path/to/your/background-image.png');
background-size: cover;
background-position: top;
}

.player {
  position: absolute;
  width: 50px;
  height: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
  font-weight: bold;
  text-align: center;
}

.player:nth-child(1) {
  background-color: red;
}

.player:nth-child(2) {
  background-color: blue;
}
</style>

