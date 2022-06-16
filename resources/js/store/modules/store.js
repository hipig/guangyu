import * as types from "../mutation-types"

// state
export const state = {
  filters: {
    platform: "",
    account_type: "",
    maps: [],
    seasons: [],
    gift_bags: [],
    hot_items: [],
    height: [],
    price_range: "",
    is_special:false,
    sort_type: 0
  },
}

// getters
export const getters = {
  filters: state => state.filters
}

// mutations
export const mutations = {
  [types.SET_FILTER]: (state, {key, value}) => {
    state.filters[key] = value
  }
}

// actions
export const actions = {
  setFilter({ commit }, {key, value}) {
    commit("SET_FILTER", {key, value})
  }
}
