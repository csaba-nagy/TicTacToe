<style>
:root {
    --grid-gap: 1rem;
    --row-count: 12;
    --column-count: 12;
    --board-bg-color: #787878;
    --cell-bg-color: #ECECEC;
}

body {
    height: 100vh;
    display: grid;
    place-items: center;
}

.board {
    display: grid;
    gap: var(--grid-gap, 1rem);
    grid-template-columns: repeat(var(--column-count), minmax(1rem, 1fr));
    grid-template-rows: repeat(var(--row-count), minmax(1rem, 1fr));
    padding: 1rem;
    background-color: var(--board-bg-color, #787878);
}

.cell {
    display: grid;
    place-items: center;
    background-color: var(--cell-bg-color, #ECECEC);
    font-size: calc(1vw + 4rem);
}
</style>

# Tic Tac Toe

<div class="board">
    <!-- row #1 -->
    <div class="cell" style="grid-area: 1/1/5/5">
        <!-- ❌ -->
        <!-- ⭕ -->
    </div>
    <div class="cell" style="grid-area: 1/5/5/9">
        <!-- ❌ -->
        <!-- ⭕ -->
    </div>
    <div class="cell" style="grid-area: 1/9/5/13">
        <!-- ❌ -->
        <!-- ⭕ -->
    </div>
    <!-- row #2 -->
    <div class="cell" style="grid-area: 5/1/9/5">
        <!-- ❌ -->
        <!-- ⭕ -->
    </div>
    <div class="cell" style="grid-area: 5/5/9/9">
        <!-- ❌ -->
        <!-- ⭕ -->
    </div>
    <div class="cell" style="grid-area: 5/9/9/13">
        <!-- ❌ -->
        <!-- ⭕ -->
    </div>
    <!-- row #3 -->
    <div class="cell" style="grid-area: 9/1/13/5">
        <!-- ❌ -->
        <!-- ⭕ -->
    </div>
    <div class="cell" style="grid-area: 9/5/13/9">
        <!-- ❌ -->
        <!-- ⭕ -->
    </div>
    <div class="cell" style="grid-area: 9/9/13/13">
        <!-- ❌ -->
        <!-- ⭕ -->
    </div>
</div>
