

import request from 'axios';
  const prefix = "masterIsPuppets";

    // optional onError function to be defined
    function get(controller:string, method:string, data:Array<any>) {
        var result, params = '';

        for (let i = 0; i < data.length; i++) {
            params += '&' + i + '=' + data[i];
        }


        const url = 'http://localhost:4000/?c=' + controller + '&m=' + method + params;

        return request.get(url,getConfig()).then(res=>{
          return res.data;
        }).catch(err=>{
          return err.data;
        })


    }

   function post(controller:string, method:string, data:Array<any>) {
        let result;
        let params = {c: controller, m: method};

        for (let i = 0; i < data.length; i++) {
            params[i] = data[i];
        }
        const url = 'http://localhost:4000/';

        return request.post(url,params,getConfig())
          .then(res=>{
            return res.data;
          })
          .catch(err=>{
            return err.data;
          })


    }

     function getConfig() {
      var config = {
        headers: {'Authorization': 'Pista',
                  'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8',
                  'X-Requested-With': 'XMLHttpRequest',

                },

      };
        if (false) {
            // var user = localStorage.get(prefix+'user');
            // if(user.id && user.token){
            //   config.headers.Authorization = user.id + ':' + user.token;
            // }
        }
        return config;
    }

const requestService = {
  get,
  post
};

export default requestService;
  // export function  upload(controller:string, method:string, url:string, files:File[]):Observable<any> {
  //       let observer;

  //       const source = Observable.create(o => {
  //           observer = o;
  //       });

  //       const formData = new FormData(), xhr = new XMLHttpRequest();

  //       for (let i = 0; i < files.length; i++) {
  //           formData.append("file[]", files[i], files[i].name);
  //       }

  //       formData.append("c", controller);
  //       formData.append("m", method);
  //       formData.append("url", url);

  //       xhr.onreadystatechange = () => {
  //           if (xhr.readyState === 4) {
  //               if (xhr.status === 200) {
  //                   observer.next({finished: true, result: JSON.parse(xhr.response)});
  //                   observer.complete();
  //               } else {
  //                   observer.error(xhr.response);
  //               }
  //           }
  //       };

  //       xhr.upload.onprogress = (event) => {
  //           const progress = Math.round(event.loaded / event.total * 100);
  //           observer.next({finished: false, progress: progress});
  //       };

  //       var token = "Pista";
  //       if (this._storage.isset('user')) {
  //           var user = this._storage.get('user');
  //           token = user.id + ':' + user.token;
  //       }

  //       xhr.open('POST', 'api/index.php', true);
  //       xhr.setRequestHeader("Authorization", token);
  //       xhr.send(formData);

  //       return source;
  //   }
