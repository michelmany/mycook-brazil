export default {
    check: () => {
        return new Promise((resolve, reject) => {
            axios.get('/user-is-logged-in')
                .then((response) => {
                    const {data, status} = response;
                    if(status === 200 && data.data === true) {
                        resolve(true)
                    }else{
                        reject(false)
                    }
                })
        })
    }
}