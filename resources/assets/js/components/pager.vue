<!--
input/props:
 - current_page: current page number 
 - qty_per_page: quantity of items for each page
 - total_item_qty: total quantity of the items 
 - handler: action(s) taken whenever specified page number changes
 
 這個頁碼最多可以顯示10頁
 如果要調整最多顯示頁數,需要調整參數
-->
<!-- todo: move css here-->

<template>
    <ul class="pagination">
        <li v-show="current_page !== 1"
            @click.prevent="previousPage()">
            <a href="#"><span aria-hidden="true">&larr;</span></a>
        </li>

        <li v-for="page in page_range"
            :class="{'active': page === current_page}"
            @click.prevent="setNewPage(page)">
            <a href="#">{{page}}</a>
        </li>

        <li v-show="Number(current_page) !== Number(total_page_qty)"
            @click.prevent="nextPage()">
            <a href="#"><span aria-hidden="true">&rarr;</span></a>
        </li>
    </ul>
</template>

<script>
  export default {
    props: {
      current_page: {
        type: [Number],
        required: true
      },
      qty_per_page: {
        type: [Number],
        required: true
      },
      total_item_qty: {
        type: [Number],
        required: true
      },
      handler: {
        type: Function,
        required: true
      },
    },
    data() {
      return {
        total_page_qty: 0,
        page_range: []
      }
    },
    methods: {
      setNewPage(newPage) {
        this.handler(newPage);
      },
      generatePageRange() {
        if (this.total_page_qty <= 10) {
          this.page_range = range(this.total_page_qty, 1);
          return;
        }

        if (this.total_page_qty > 10) {
          if ((this.current_page + 4) > this.total_page_qty) {
            this.page_range = range(10, this.total_page_qty - 9);
            return;
          }

          if (this.current_page <= 6) {
            this.page_range = range(10, 1);
            return;
          }

          if (this.current_page > 6) {
            this.page_range = range(10, this.current_page - 5);
            return;
          }
        }
      },
      previousPage() {
        if (this.current_page <= 1) {
          return;
        }

        this.setNewPage(this.current_page - 1)
      },
      nextPage() {
        if (this.current_page >= this.total_page_qty) {
          return;
        }
        
        this.setNewPage(this.current_page + 1)
      },
    },
    watch: {
      total_item_qty: function () {
        this.total_page_qty = Math.ceil(this.total_item_qty / this.qty_per_page);
      },
      total_page_qty: function () {
        this.generatePageRange();
      },
      current_page: function () {
        this.generatePageRange();
      },
    },
  }

  function range(size, startAt = 0) {
    return [...Array(size).keys()].map(i => i + startAt);
  }
</script>


