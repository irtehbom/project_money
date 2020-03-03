POST 
XHR 
http://localhost/project_money/products/load_amazon_data [HTTP/1.1 200 OK 690ms]
Headers
POST
Response
Cookies
Call Stack
array(2) {
  ["OperationRequest"]=>
  array(4) {
    ["HTTPHeaders"]=>
    array(1) {
      [0]=>
      array(1) {
        ["@attributes"]=>
        array(2) {
          ["Name"]=>
          string(9) "UserAgent"
          ["Value"]=>
          string(38) "GuzzleHttp/6.2.1 curl/7.40.0 PHP/5.6.8"
        }
      }
    }
    ["RequestId"]=>
    string(36) "9764d7f3-f691-4c88-aea8-b94e9bfc0371"
    ["Arguments"]=>
    array(1) {
      ["Argument"]=>
      array(9) {
        [0]=>
        array(1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(14) "AWSAccessKeyId"
            ["Value"]=>
            string(20) "AKIAIS6GFHYX2U3N4PRA"
          }
        }
        [1]=>
        array(1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(12) "AssociateTag"
            ["Value"]=>
            string(15) "onlimovirevi-21"
          }
        }
        [2]=>
        array(1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(6) "ItemId"
            ["Value"]=>
            string(10) "B01M697EVY"
          }
        }
        [3]=>
        array(1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(9) "Operation"
            ["Value"]=>
            string(10) "ItemLookup"
          }
        }
        [4]=>
        array(1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(13) "ResponseGroup"
            ["Value"]=>
            string(19) "Images,OfferSummary"
          }
        }
        [5]=>
        array(1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(7) "Service"
            ["Value"]=>
            string(19) "AWSECommerceService"
          }
        }
        [6]=>
        array(1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(9) "Timestamp"
            ["Value"]=>
            string(20) "2017-03-29T15:01:52Z"
          }
        }
        [7]=>
        array(1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(7) "Version"
            ["Value"]=>
            string(10) "2013-08-01"
          }
        }
        [8]=>
        array(1) {
          ["@attributes"]=>
          array(2) {
            ["Name"]=>
            string(9) "Signature"
            ["Value"]=>
            string(44) "L6V6JwGXMIKDinyFm0CEXbcBqqROEWUtaXvP0M2W1tw="
          }
        }
      }
    }
    ["RequestProcessingTime"]=>
    string(18) "0.0197129260000000"
  }
  ["Items"]=>
  array(2) {
    ["Request"]=>
    array(2) {
      ["IsValid"]=>
      string(4) "True"
      ["ItemLookupRequest"]=>
      array(4) {
        ["IdType"]=>
        string(4) "ASIN"
        ["ItemId"]=>
        string(10) "B01M697EVY"
        ["ResponseGroup"]=>
        array(2) {
          [0]=>
          string(6) "Images"
          [1]=>
          string(12) "OfferSummary"
        }
        ["VariationPage"]=>
        string(3) "All"
      }
    }
    ["Item"]=>
    array(7) {
      ["ASIN"]=>
      string(10) "B01M697EVY"
      ["ParentASIN"]=>
      string(10) "B01M697EVY"
      ["SmallImage"]=>
      array(3) {
        ["URL"]=>
        string(71) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL._SL75_.jpg"
        ["Height"]=>
        string(2) "75"
        ["Width"]=>
        string(2) "58"
      }
      ["MediumImage"]=>
      array(3) {
        ["URL"]=>
        string(72) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL._SL160_.jpg"
        ["Height"]=>
        string(3) "160"
        ["Width"]=>
        string(3) "123"
      }
      ["LargeImage"]=>
      array(3) {
        ["URL"]=>
        string(64) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL.jpg"
        ["Height"]=>
        string(3) "500"
        ["Width"]=>
        string(3) "385"
      }
      ["ImageSets"]=>
      array(1) {
        ["ImageSet"]=>
        array(3) {
          [0]=>
          array(8) {
            ["@attributes"]=>
            array(1) {
              ["Category"]=>
              string(6) "swatch"
            }
            ["SwatchImage"]=>
            array(3) {
              ["URL"]=>
              string(71) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL._SL30_.jpg"
              ["Height"]=>
              string(2) "30"
              ["Width"]=>
              string(2) "23"
            }
            ["SmallImage"]=>
            array(3) {
              ["URL"]=>
              string(71) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL._SL75_.jpg"
              ["Height"]=>
              string(2) "75"
              ["Width"]=>
              string(2) "58"
            }
            ["ThumbnailImage"]=>
            array(3) {
              ["URL"]=>
              string(71) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL._SL75_.jpg"
              ["Height"]=>
              string(2) "75"
              ["Width"]=>
              string(2) "58"
            }
            ["TinyImage"]=>
            array(3) {
              ["URL"]=>
              string(72) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL._SL110_.jpg"
              ["Height"]=>
              string(3) "110"
              ["Width"]=>
              string(2) "85"
            }
            ["MediumImage"]=>
            array(3) {
              ["URL"]=>
              string(72) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL._SL160_.jpg"
              ["Height"]=>
              string(3) "160"
              ["Width"]=>
              string(3) "123"
            }
            ["LargeImage"]=>
            array(3) {
              ["URL"]=>
              string(64) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL.jpg"
              ["Height"]=>
              string(3) "500"
              ["Width"]=>
              string(3) "385"
            }
            ["HiResImage"]=>
            array(3) {
              ["URL"]=>
              string(64) "https://images-na.ssl-images-amazon.com/images/I/81ce4DmgQmL.jpg"
              ["Height"]=>
              string(4) "2560"
              ["Width"]=>
              string(4) "1969"
            }
          }
          [1]=>
          array(8) {
            ["@attributes"]=>
            array(1) {
              ["Category"]=>
              string(7) "variant"
            }
            ["SwatchImage"]=>
            array(3) {
              ["URL"]=>
              string(71) "https://images-na.ssl-images-amazon.com/images/I/414uoYJv9VL._SL30_.jpg"
              ["Height"]=>
              string(2) "30"
              ["Width"]=>
              string(2) "23"
            }
            ["SmallImage"]=>
            array(3) {
              ["URL"]=>
              string(71) "https://images-na.ssl-images-amazon.com/images/I/414uoYJv9VL._SL75_.jpg"
              ["Height"]=>
              string(2) "75"
              ["Width"]=>
              string(2) "58"
            }
            ["ThumbnailImage"]=>
            array(3) {
              ["URL"]=>
              string(71) "https://images-na.ssl-images-amazon.com/images/I/414uoYJv9VL._SL75_.jpg"
              ["Height"]=>
              string(2) "75"
              ["Width"]=>
              string(2) "58"
            }
            ["TinyImage"]=>
            array(3) {
              ["URL"]=>
              string(72) "https://images-na.ssl-images-amazon.com/images/I/414uoYJv9VL._SL110_.jpg"
              ["Height"]=>
              string(3) "110"
              ["Width"]=>
              string(2) "85"
            }
            ["MediumImage"]=>
            array(3) {
              ["URL"]=>
              string(72) "https://images-na.ssl-images-amazon.com/images/I/414uoYJv9VL._SL160_.jpg"
              ["Height"]=>
              string(3) "160"
              ["Width"]=>
              string(3) "123"
            }
            ["LargeImage"]=>
            array(3) {
              ["URL"]=>
              string(64) "https://images-na.ssl-images-amazon.com/images/I/414uoYJv9VL.jpg"
              ["Height"]=>
              string(3) "500"
              ["Width"]=>
              string(3) "385"
            }
            ["HiResImage"]=>
            array(3) {
              ["URL"]=>
              string(64) "https://images-na.ssl-images-amazon.com/images/I/81IsY9q5ozL.jpg"
              ["Height"]=>
              string(4) "2560"
              ["Width"]=>
              string(4) "1969"
            }
          }
          [2]=>
          array(8) {
            ["@attributes"]=>
            array(1) {
              ["Category"]=>
              string(7) "primary"
            }
            ["SwatchImage"]=>
            array(3) {
              ["URL"]=>
              string(71) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL._SL30_.jpg"
              ["Height"]=>
              string(2) "30"
              ["Width"]=>
              string(2) "23"
            }
            ["SmallImage"]=>
            array(3) {
              ["URL"]=>
              string(71) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL._SL75_.jpg"
              ["Height"]=>
              string(2) "75"
              ["Width"]=>
              string(2) "58"
            }
            ["ThumbnailImage"]=>
            array(3) {
              ["URL"]=>
              string(71) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL._SL75_.jpg"
              ["Height"]=>
              string(2) "75"
              ["Width"]=>
              string(2) "58"
            }
            ["TinyImage"]=>
            array(3) {
              ["URL"]=>
              string(72) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL._SL110_.jpg"
              ["Height"]=>
              string(3) "110"
              ["Width"]=>
              string(2) "85"
            }
            ["MediumImage"]=>
            array(3) {
              ["URL"]=>
              string(72) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL._SL160_.jpg"
              ["Height"]=>
              string(3) "160"
              ["Width"]=>
              string(3) "123"
            }
            ["LargeImage"]=>
            array(3) {
              ["URL"]=>
              string(64) "https://images-na.ssl-images-amazon.com/images/I/413TeR8-CpL.jpg"
              ["Height"]=>
              string(3) "500"
              ["Width"]=>
              string(3) "385"
            }
            ["HiResImage"]=>
            array(3) {
              ["URL"]=>
              string(64) "https://images-na.ssl-images-amazon.com/images/I/81ce4DmgQmL.jpg"
              ["Height"]=>
              string(4) "2560"
              ["Width"]=>
              string(4) "1969"
            }
          }
        }
      }
      ["OfferSummary"]=>
      array(4) {
        ["TotalNew"]=>
        string(1) "0"
        ["TotalUsed"]=>
        string(1) "0"
        ["TotalCollectible"]=>
        string(1) "0"
        ["TotalRefurbished"]=>
        string(1) "0"
      }