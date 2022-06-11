export default {
    namespaced: true,
    state:{
        user:{},
        token:null
    },
    getters:{
        user: state => state.user,
        token: state => state.token
    },
    actions:{
        setUser({state}, { user, token }){
            state.user = user
            state.token = token

            if (token)
                localStorage.setItem('token', token)
        }
    }
}
