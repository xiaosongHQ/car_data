
Page({
  /** 
   * 页面的初始数据 
   */
  data: {
    isActive: null,
    listMain: [],
    listTitles: [],
    fixedTitle: null,
    toView: 'inToView0',
    oHeight: [],
    scroolHeight: 0
  },
  //点击右侧字母导航定位触发
  scrollToViewFn: function (e) {
    var that = this;
    var _id = e.target.dataset.id;
    for (var i = 0; i < that.data.listMain.length; ++i) {
      if (that.data.listMain[i].id === _id) {
        that.setData({
          isActive: _id,
          toView: 'inToView' + _id
        })
        break
      }
    }
  },
  toBottom: function (e) {
    console.log(e)
  },
  // 页面滑动时触发
  onPageScroll: function (e) {
    this.setData({
      scroolHeight: e.detail.scrollTop
    });
    for (let i in this.data.oHeight) {
      if (e.detail.scrollTop < this.data.oHeight[i].height) {
        this.setData({
          isActive: this.data.oHeight[i].key,
          fixedTitle: this.data.oHeight[i].name
        });
        return false;
      }
    }

  },
  // 处理数据格式，及获取分组高度
  getBrands: function () {
    var that = this;
    wx.request({
      url: 'http://ws.xiaohigh.com/car/list',
      success(res) {
        console.log(res.data)
        if (true) {
          var someTtitle = null;
          var someArr = [];
          for (var i = 0; i < res.data.length; i++) {
            console.log(123)
            var newBrands = { brandId: res.data[i].brandId, name: res.data[i].brandName };
            if (res.data[i].initial != someTtitle) {
              someTtitle = res.data[i].initial
              var newObj = {
                id: i,
                region: someTtitle,
                brands: []
              };
              someArr.push(newObj)
            }
            newObj.brands.push(newBrands);

          };
          //赋值给列表值
          that.setData({
            listMain: someArr
          });
          //赋值给当前高亮的isActive
          that.setData({
            isActive: that.data.listMain[0].id,
            fixedTitle: that.data.listMain[0].region
          });

          //计算分组高度,wx.createSelectotQuery()获取节点信息
          var number = 0;
          for (let i = 0; i < that.data.listMain.length; ++i) {
            wx.createSelectorQuery().select('#inToView' + that.data.listMain[i].id).boundingClientRect(function (rect) {
              number = rect.height + number;
              var newArry = [{ 'height': number, 'key': rect.dataset.id, "name": that.data.listMain[i].region }]
              that.setData({
                oHeight: that.data.oHeight.concat(newArry)
              })

            }).exec();
          };

        }
      }
    })
  },
  onLoad: function (options) {
    var that = this;
    that.getBrands();


  }
})