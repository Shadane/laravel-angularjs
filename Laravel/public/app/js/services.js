'use strict';
var services = angular.module('services', []);

/* --------------------------------------------
 ' dataFactory
 ' --------------------------------------------
 ' Сервис для связи с сервером по $http, также 
 ' хранения \ изменения загруженных данных
 ' --------------------------------------------
 */
services.factory('dataFactory', ['$http', function ($http) {
            var promise = null;
            var data = null;
            return {
                  /* -----------------------------------------------------------------------
                   * load
                   * -----------------------------------------------------------------------
                   * Если еще не загружали в текущей сессии данные с сервера, то создается 
                   * промис, который и возвращается из фактори. По окончанию загрузки 
                   * в переменную 'data' кладется 'response.data' . В дальнейшем 
                   * эти данные можно получить по ссылке функцией 'getData'.
                   * -----------------------------------------------------------------------
                   */
                  load: function () {
                        if (promise === null) {
                              promise = $http.get('/api/ads').success(function (response) {
                                    if (angular.isArray(response.ads)) {
                                          response.ads = {};
                                    }
                                    if (angular.isArray(response.authors)) {
                                          response.authors = {};
                                    }
                                    data = response;
                              }).error(function () {
                              });
                        }
                        return promise;
                  },
                  /* --------------------------------------------------------------
                   * save
                   * --------------------------------------------------------------
                   * Это функция сохранения и обновления. В ней возвращаем промис, 
                   * по получении ответа редактируем массив 'data' в зависимо-
                   * сти от ответа. Сначала сохранение\обновление автора,
                   * затем сохранение объявления. На ошибку заглушка.
                   * --------------------------------------------------------------
                   */
                  save: function (postData) {
                        return  $http.post('/api/ads', postData).success(function (response) {

                              var resp = response;
                              var auId = resp.author.id;
                              var adId = resp.ad.id;
                              if (resp.author.status == 'success') {
                                    if (resp.author.action == 'save') {
                                          data.authors[auId] = {'email': postData.email, 'seller_name': postData.seller_name, 'id': auId};

                                    } else if (resp.author.action == 'update') {

                                          data.authors[auId].seller_name = postData.seller_name;
                                    }
                              }
                              if (resp.ad.status == 'success') {
                                    postData.author_id = auId;
                                    postData.id = adId;
                                    data.ads[adId] =
                                            {
                                                  'id': adId,
                                                  'author_id': auId,
                                                  'title': postData.title,
                                                  'price': postData.price,
                                                  'private': postData.private
                                            };
                              }

                        }).error(function () {
                        });
                  },
                  /*---------------------------------------------
                   * Delete
                   * --------------------------------------------
                   * Передаем по http айди удаляемого объявления,
                   * по получении ответа удаляем объявление 
                   * из массива data. Заглушка на ошибку
                   * --------------------------------------------
                   */
                  delete: function (id) {
                        return $http.delete('/api/ads/' + id).success(function (response) {
                              if (response.status == 'success') {
                                    delete(data.ads[id]);
                              }
                        }).error(function () {
                        });
                  },
                  /* --------------------------------------------------------------
                   * Show
                   * --------------------------------------------------------------
                   * Функция возвращения объявления из базы данных для дальнейшего
                   * редактирования. Нажимая на кнопку Редактировать-возвращаем
                   * промис, по исполнению - в контроллере функция .success,
                   * которая передает респонс в formFactory, а тот сервис 
                   * уже заполняет поля формы. Для ошибок - заглушка.
                   * --------------------------------------------------------------
                   */
                  show: function (id) {
                        return $http.get('/api/ads/' + id).error(function () {
                        });
                  },
                   /* --------------------------------------------------------------
                   * getData
                   * --------------------------------------------------------------
                   * Получаем города, категории, объявления, авторов по ссылке.
                   * --------------------------------------------------------------
                   */
                  getData: function () {
                        
                        return data;
                  }
            };

      }]);
/* -----------------------------------------------------------------------------
 ' formFactory
 ' -----------------------------------------------------------------------------
 ' Cервис значений формы. В самом начале при создании контроллера используется 
 ' 'getForm()' , чтобы получить ссылку на formVals. В дальнейшем используем
 ' 'resetForm()' при сохранении объявления и удаления. Функция fillForm()
 ' на входе получает объект, загруженный с сервера, и заполняет с помо
 ' щью него форму. Функция auFill заполняет поля seller_name и email 
 ' -----------------------------------------------------------------------------
 */
services.factory('formFactory', function () {
      var formVals = {private: 0, price: 0};
      return{
            getForm: function () {
                  return formVals;
            },
            /* ----------------------------------------------  
             *                Резет формы
             * ----------------------------------------------
             */
            resetForm: function () {
                  angular.copy({private: 0, price: 0}, formVals);
            },
            /* ----------------------------------------------  
             *         Заполнение формы из объекта
             * ----------------------------------------------
             */
            fillForm: function (filldata)
            {
                  var adData = filldata.ad;
                  var auData = filldata.author;

                  formVals.category_id = adData.category_id;
                  formVals.private = adData.private;
                  formVals.allow_mails = adData.allow_mails > 0;
                  formVals.phone = adData.phone;
                  formVals.location_id = adData.location_id;
                  formVals.title = adData.title;
                  formVals.description = adData.description;
                  formVals.price = parseInt(adData.price, 10);
                  formVals.id = adData.id;

                  this.auFill(auData.email, auData.seller_name);

            },
            /* ----------------------------------------------  
             *    Заполнение полей seller_name и email
             * ----------------------------------------------
             */
            auFill: function (mail, name)
            {
                  formVals.seller_name = name;
                  formVals.email = mail;
            }
      };
});

/* -----------------------------------------------------------------------------
 ' dataFactoryInterceptor
 ' -----------------------------------------------------------------------------
 ' Он отвечает за обнаружение и обработку ошибок, полученных в результате 
 ' запросов на сервер. Также при очередной отправке запроса он очищает
 ' хранилище ошибок валидации. Это для того, чтобы после успешной
 ' отправки у нас не оставалось уведомлений о неправильно за-
 ' полненой форме. Также на все статусы ошибок кроме 422 
 ' ставит броадкаст на $rootScope, отсылает туда же 
 ' код ошибки. При 422ой - в $rootScope.errs[422]
 ' передаются текущие ошибки валидации формы.
 ' Затем делаем $q.reject() для остановки.
 ' -----------------------------------------------------------------------------
 */
services.factory('dataFactoryInterceptor', function ($q, $rootScope) {
      $rootScope.errs = [];
      $rootScope.errStatus = {};
      return {
            /* ----------------------------------------------  
             *                При запросе
             * ----------------------------------------------
             */
            request: function (config) {
                  $rootScope.errs[422] = {};
                  return config;
            },
            /* ----------------------------------------------  
             *                При ошибке
             * ----------------------------------------------
             */
            responseError: function (response) {
                  if (response.status != 422) {
                        $rootScope.errStatus = response.status;
                        $rootScope.$broadcast('response error');

                  } else if (response.status == 422) {
                        $rootScope.errs[422] = response.data;

                  }
                  return $q.reject(response);
            }

      }
});

/* -----------------------------------------------------------------------------
 ' messageFactory
 ' -----------------------------------------------------------------------------
 ' Сервис всплывающих сообщений. Два контейнера. При создании контроллера формы
 ' он загружает ссылки на эти контейнеры с помощью 'getAdMsg' и 'getAuMsg'.
 ' Третья функция - 'setMsg' - используется в различных местах программы
 ' Для установки сообщений. Атрибут 'show' указывает на то, показывать
 ' ли сообщения или нет. При установке сообщений также задейстован
 ' '$timeout'. Это для визуального эффекта. Переменная 'delay' 
 ' отвечает за задержку между выключением предыдущего сооб
 ' щения и показом следующего. Функция hideMsgs отвечает
 ' за скрывание наших контейнеров при нажатии на Х 
 ' -----------------------------------------------------------------------------
 */
services.factory('messageFactory', ['$timeout', function ($timeout) {
            var adMsg = {message: '', class: 'alert-info', show: false};
            var auMsg = {message: '', class: 'alert-success', show: false};
            return {
                  getAdMsg: function () {
                        return adMsg;
                  },
                  getAuMsg: function () {
                        return auMsg;
                  },
                  /* ----------------------------------------------  
                   *    функция для установки сообщений.
                   * ----------------------------------------------
                   */
                  setMsg: function (msgBox, msg, clss, delay) {
                        if (msgBox=='auMsg') { msgBox = auMsg;}
                        else { msgBox = adMsg; };
                        msgBox.show = false;
                        $timeout(function () {
                              msgBox.message = msg;
                              msgBox.class = clss;
                              msgBox.show = true;
                        }, delay);

                  },
                  /* ----------------------------------------------  
                   *    функция для закрытия мессаджбоксов.
                   * ----------------------------------------------
                   */
                  hideMsgs: function (msgBoxToHide) {
                        if (msgBoxToHide === 'hide auMsg box') {
                              auMsg.show = false;
                        }
                        else if (msgBoxToHide === 'hide adMsg box') {
                              adMsg.show = false;
                        }
                  }
            }

      }]);