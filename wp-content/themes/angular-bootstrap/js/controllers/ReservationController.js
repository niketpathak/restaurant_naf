//Reservation Controller
app.controller('ReservationController',
	['$scope', '$http', '$routeParams', '$sce','CacheMenuService', 'CacheCategoryService', '$timeout', function($scope, $http, $routeParams, $sce, CacheMenuService, CacheCategoryService, $timeout) {
			$scope.doc_root = doc_root;
			$scope.today_date = new Date();
			$scope.book_time = "19:30";
			$scope.partysize = "2"
			$scope.rest_stat = "";
			$scope.rest_stat_hide = true;
			$scope.reservation_forceDisable = false;
			$scope.ajax_loader_hide = true;

			$scope.today = function() {
				$scope.dt = new Date();
			};
			$scope.today();

			$scope.clear = function() {
				$scope.dt = null;
			};

			$scope.inlineOptions = {
				minDate: new Date(),
				showWeeks: true
			};

			$scope.dateOptions = {
				dateDisabled: disabled,
				formatYear: 'yy',
				maxDate: new Date(2020, 5, 22),
				minDate: new Date(),
				startingDay: 1
			};

			// Disable previous days selection
			function disabled(data) {
				return data.mode === 'day' && (data.date < $scope.today_date);
			}

			$scope.open1 = function() {
				$scope.popup1.opened = true;
			};

			$scope.setDate = function(year, month, day) {
				$scope.dt = new Date(year, month, day);
			};

			$scope.format = 'dd-MMMM-yyyy';
			$scope.altInputFormats = ['M!/d!/yyyy'];

			$scope.popup1 = {
				opened: false
			};
			//generate reservation times
			$scope.open_times = [
				"12", "12:30", "13:00", "13:30", "14:00", "14:30",
				"19:00","19:30","20:00","20:30","21:00","21:30","22:00","22:30","23:00","23:30"
			];
			//generate range for party size
			$scope.range = _.range(1, 11);
		
			//handle form submit
			$scope.submitReservationRequest = function () {
				$scope.reservation_forceDisable = true;
				$scope.ajax_loader_hide = false;
				var data_in = {
					"name": $scope.name,
					"email": $scope.email,
					"booking_date": $scope.dt,
					"partysize": $scope.partysize,
					"booking_time": $scope.book_time
				};
				$http.post(doc_root+'/make_reservation.php', data_in).then(function(e){
					// console.log('success fired',e);
					$scope.ajax_loader_hide = true;
					$scope.rest_stat_hide = false;
					if(e.data.res==0) {
						$scope.reservation_forceDisable = false;
					}
					$scope.rest_stat = e.data.msg;
					$timeout(function () {
						$scope.rest_stat = "";
						$scope.rest_stat_hide = true;
					}, 4000);
				}, function(e){
					//@to-do: handle failure of ajax req
				});
			}

		}
	]
);